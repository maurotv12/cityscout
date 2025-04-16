<?php


namespace App\Models;

use mysqli;

class Model {
    protected $db_host= DB_HOST;
    protected $db_user= DB_USER;
    protected $db_pass= DB_PASS;
    protected $db_name= DB_NAME;

    protected $connection;
    protected $query; 
    protected $table;

    public function __construct(){
        $this->connection();
    }

    public function connection() {
      
        $this->connection = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
    
        if($this->connection->connect_error){
            die('Error de conexión: ' . $this->connection->connect_error);
        }
    }

    public function query ($sql, $data = [], $params = null){

        if($data){

            if($params == null){
                $params = str_repeat('s', count($data)); //consultas preparadas
            }

            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param($params, ...$data);
            $stmt->execute();
    
            $this->query = $stmt->get_result();
        }else{
            $this->query = $this->connection->query($sql);
        }
        return $this;
    
    }

    public function first (){
        return $this->query->fetch_assoc();
    }

    public function get(){
        return $this->query->fetch_all(MYSQLI_ASSOC);
    }

    //Consultas
    public function all(){

        $sql = "SELECT * FROM {$this->table}";
        return $this->query($sql)->get();
    }

    public function find ($id){
        //SELECT FROM users WHERE id = 1
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->query($sql, [$id], 'i')->first();
    }

    public function where ($column, $operator, $value = null){   
        if($value == null){
            $value = $operator;
            $operator = '='; 
        } 
        //prevención de inyección sql a nuestro código
        // $value = $this->connection->real_escape_string($value);

         //SELECT FROM users WHERE fullname = mauricio
        $sql = "SELECT * FROM {$this->table} WHERE {$column} {$operator} ?";

        $this->query($sql, [$value], 's');
        return $this;
    }

    //Create

    public function create($data){
        //INSERT INTO users (name, email) VALUES ('Mauricio','Mauricio@gmail.com')
        $columns = array_keys($data);
        $columns = implode(", ", $columns); 
        
        $values = array_values($data);
        //Sentencias preparadas
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES (" . str_repeat('?, ', count($values) -1) . "?)";
            
        $this->query($sql, $values);
        
        $insert_id =$this->connection->insert_id;

        return $this->find($insert_id);
    }

    //Update

    public function update($id, $data){
        //UPDATE users SET fullname = 'Mauricio', email = 'Mauricio@gmail.com' WHERE id = 1
        
        $fields =[];

        foreach($data as $key => $value){
            $fields[] = "{$key} = ?";
        }

        $fields = implode(', ', $fields);
        
        $sql = "UPDATE {$this->table} SET {$fields} WHERE id = ?";

        $values = array_values($data);
        $values[] = $id;

        $this->query($sql, $values);

        return $this->find($id);
    }
    
    //Delete

    public function delete($id){
        //DELETE FROM users WHERE id = 1
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $this->query($sql, [$id], 'i');
    }

}