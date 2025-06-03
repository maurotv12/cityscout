<?php

namespace App\Models;

use PDO;
use PDOException;

class Model
{
    protected $db_host = DB_HOST;
    protected $db_user = DB_USER;
    protected $db_pass = DB_PASS;
    protected $db_name = DB_NAME;

    protected $connection;
    protected $query;
    protected $table;

    public $hidden = [];

    protected $wheres = [];
    protected $orderBy = '';
    protected $limit = '';

    public function __construct()
    {
        $this->connection();
    }

    public function connection()
    {
        $dsn = "mysql:host={$this->db_host};dbname={$this->db_name};charset=utf8mb4";
        try {
            $this->connection = new PDO($dsn, $this->db_user, $this->db_pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die('Error de conexión: ' . $e->getMessage());
        }
    }

    public function query($sql, $data = [])
    {
        if ($data) {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($data);
            $this->query = $stmt;
        } else {
            $this->query = $this->connection->query($sql);
        }
        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $this->orderBy = "ORDER BY {$column} {$direction}";
        return $this;
    }

    public function limit($number)
    {
        $this->limit = "LIMIT " . intval($number);
        return $this;
    }

    public function get()
    {
        if (!empty($this->wheres)) {
            list($whereSql, $values) = $this->buildWhereQuery();
            $sql = "SELECT * FROM {$this->table} {$whereSql} {$this->orderBy} {$this->limit}";
            $result = $this->query($sql, $values)->query->fetchAll();
            $this->wheres = [];
        } else {
            $sql = "SELECT * FROM {$this->table} {$this->orderBy} {$this->limit}";
            $result = $this->query($sql)->query->fetchAll();
        }
        $this->orderBy = '';
        $this->limit = '';
        if ($result === false) $result = [];

        // Ocultar campos privados
        if (!empty($this->hidden)) {
            foreach ($result as &$row) {
                foreach ($this->hidden as $field) {
                    unset($row[$field]);
                }
            }
        }
        return $result;
    }

    public function first()
    {
        if (!empty($this->wheres)) {
            list($whereSql, $values) = $this->buildWhereQuery();
            $sql = "SELECT * FROM {$this->table} {$whereSql} LIMIT 1";
            $result = $this->query($sql, $values)->query->fetch();
            $this->wheres = [];
        } else {
            $result = $this->query->fetch();
        }
        if ($result === false) $result = null;
        // Ocultar campos privados
        if (!empty($this->hidden) && is_array($result)) {
            foreach ($this->hidden as $field) {
                unset($result[$field]);
            }
        }
        return $result;
    }

    //Consultas
    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->query($sql)->get();
    }

    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->query($sql, [$id])->first();
    }

    public function where($column, $operator, $value = null)
    {
        // Permitir sintaxis where('columna', valor)
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        // Soporte para IN y NOT IN
        if (in_array(strtoupper($operator), ['IN', 'NOT IN']) && is_array($value)) {
            if (empty($value)) {
                // Si el array está vacío, forzamos una condición falsa
                $this->wheres[] = ["1", "=", "0"];
            } else {
                $placeholders = implode(', ', array_fill(0, count($value), '?'));
                $this->wheres[] = [
                    "{$column} {$operator} ($placeholders)",
                    'IN',
                    $value
                ];
            }
        } else {
            $this->wheres[] = [$column, $operator, $value];
        }
        return $this;
    }

    protected function buildWhereQuery()
    {
        if (empty($this->wheres)) {
            return ['', []];
        }
        $clauses = [];
        $values = [];
        foreach ($this->wheres as $where) {
            if ($where[1] === 'IN') {
                $clauses[] = $where[0];
                $values = array_merge($values, $where[2]);
            } else {
                $clauses[] = "{$where[0]} {$where[1]} ?";
                $values[] = $where[2];
            }
        }
        $whereSql = 'WHERE ' . implode(' AND ', $clauses);
        return [$whereSql, $values];
    }

    //Create
    public function create($data)
    {
        $columns = array_keys($data);
        $columnsSql = implode(", ", $columns);

        $values = array_values($data);
        $placeholders = implode(', ', array_fill(0, count($values), '?'));
        $sql = "INSERT INTO {$this->table} ({$columnsSql}) VALUES ({$placeholders})";

        $this->query($sql, $values);

        $insert_id = $this->connection->lastInsertId();

        return $this->find($insert_id);
    }

    //Update
    public function update($id, $data)
    {
        $set = [];
        foreach ($data as $column => $value) {
            $set[] = "{$column} = ?";
        }
        $setSql = implode(', ', $set);

        $sql = "UPDATE {$this->table} SET {$setSql} WHERE id = ?";
        $params = array_values($data);
        $params[] = $id;


        return $this->query($sql, $params);
    }

    //Delete
    public function delete($id = null)
    {
        if ($id !== null) {
            // Eliminar por ID
            $sql = "DELETE FROM {$this->table} WHERE id = ?";
            $this->query($sql, [$id]);
            return $this;
        } elseif (!empty($this->wheres)) {
            // Eliminar por condiciones (deleteWhere)
            list($whereSql, $values) = $this->buildWhereQuery();
            $sql = "DELETE FROM {$this->table} {$whereSql}";
            $this->query($sql, $values);
            $this->wheres = [];
            return $this;
        }
        // Si no hay ID ni condiciones, no hace nada
        return false;
    }
}
