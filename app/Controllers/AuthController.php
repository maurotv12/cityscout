<?php

namespace App\Controllers;

use App\Models\User;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class AuthController extends Controller
{

    public function login()
    {
        return $this->view('auth.login');
    }

    public function loginPost()
    {
        session_start();

        $username = $_POST['userName'];
        $password = $_POST['password'];

        $userModel = new User();
        $userModel->hidden = [];
        $user = $userModel->where('username', '=', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header('Location: /'); // Redirige al inicio o dashboard
            exit;
        } else {
            $_SESSION['error'] = 'Credenciales incorrectas';
            header('Location: /login');
            exit;
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /login');
        exit;
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'] ?? '';
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $birth_date = $_POST['birth_date'] ?? '';

            // Validación básica
            if (!$fullname || !$username || !$email || !$password || !$birth_date) {
                $_SESSION['error'] = 'Todos los campos obligatorios deben ser completados.';
                return header('Location: /register');
            }

            // Encriptar la contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Procesar imagen como BLOB
            $profile_photo = null;
            if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
                $profile_photo = file_get_contents($_FILES['profile_photo']['tmp_name']);
            }

            $userModel = new User();

            $created_at = date('Y-m-d H:i:s');
            $updated_at = $created_at;

            $user = $userModel->create([
                'fullname' => $fullname,
                'username' => strtolower($username),
                'email' => strtolower($email),
                'password' => $hashedPassword,
                'birth_date' => $birth_date,
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ]);

            // Crear sesión y redirigir
            $_SESSION['user'] = $user;
            header('Location: /');
            exit;
        }

        return $this->view('auth.register');
    }

    public function forgotPassword()
    {
        return $this->view('auth.forgotPassword');
    }

    public function forgotPasswordPost()
    {
        session_start();
        $email = $_POST['email'] ?? '';
        if (!$email) {
            $_SESSION['error'] = 'Debes ingresar tu correo.';
            return header('Location: /forgot-password');
        }

        $userModel = new User;
        $user = $userModel->where('email', '=', $email)->first();

        if (!$user) {
            $_SESSION['error'] = 'No existe una cuenta con ese correo.';
            return header('Location: /forgot-password');
        }

        // Generar token seguro
        $token = bin2hex(random_bytes(32));
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Guardar en password_resets (PDO)
        $pdo = $userModel->getConnection();
        $stmt = $pdo->prepare("INSERT INTO password_resets (user_id, tokeen, expires_at, used, created_at) VALUES (?, ?, ?, 0, NOW())");
        $stmt->execute([$user['id'], $hashedToken, $expiresAt]);

        // Enviar correo con PHPMailer
        require_once __DIR__ . '/../../vendor/autoload.php';
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'live.smtp.mailtrap.io'; // Cambiar en producción
            $mail->SMTPAuth = true;
            $mail->Username = 'smtp@mailtrap.io'; // Cambiar en producción
            $mail->Password = 'ea18c831f393f693543cfc92926e3e67'; // Cambiar en producción
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->CharSet = 'UTF-8';

            $mail->setFrom('hello@demomailtrap.co', 'Focuz');
            $mail->addAddress($user['email'], $user['fullname']);
            $mail->isHTML(true);
            $mail->Subject = 'Restablece tu contraseña en Focuz';
            $resetLink = "http://{$_SERVER['HTTP_HOST']}/reset-password?token=$token";
            $mail->Body = "Hola {$user['fullname']},<br><br>
                Hemos recibido una solicitud de restablecimiento de contraseña. <br>
                Si fuiste tu, haz clic en el siguiente enlace para completar el proceso:<br>
                <a href='$resetLink'>$resetLink</a><br><br>
                Si no solicitaste este cambio, ignora este correo.<br><br>
                El enlace expirará en 1 hora.";

            $mail->send();
            $_SESSION['success'] = 'Se ha enviado un correo para restablecer tu contraseña.';
        } catch (Exception $e) {
            $_SESSION['error'] = 'No se pudo enviar el correo. Intenta más tarde. Detalle: ' . $mail->ErrorInfo;
        }
        header('Location: /forgot-password');
        exit;
    }

    public function resetPassword()
    {
        session_start();
        $token = $_GET['token'] ?? '';
        if (!$token) {
            $_SESSION['error'] = 'Token inválido.';
            return header('Location: /login');
        }
        return $this->view('auth.resetPassword', ['token' => $token]);
    }

    public function resetPasswordPost()
    {
        session_start();
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';

        if (!$token || !$password || !$password2) {
            $_SESSION['error'] = 'Completa todos los campos.';
            return header("Location: /reset-password?token=$token");
        }
        if ($password !== $password2) {
            $_SESSION['error'] = 'Las contraseñas no coinciden.';
            return header("Location: /reset-password?token=$token");
        }
        if (!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/', $password)) {
            $_SESSION['error'] = 'La contraseña no cumple los requisitos.';
            return header("Location: /reset-password?token=$token");
        }

        // Buscar token en la base de datos (PDO)
        $userModel = new User;
        $pdo = $userModel->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE used = 0 AND expires_at > NOW()");
        $stmt->execute();
        $resetRows = $stmt->fetchAll();
        $resetRow = null;
        foreach ($resetRows as $row) {
            if (password_verify($token, $row['tokeen'])) {
                $resetRow = $row;
                break;
            }
        }
        if (!$resetRow) {
            $_SESSION['error'] = 'El enlace es inválido o ha expirado.';
            return header('Location: /login');
        }

        // Actualizar contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $userModel->update($resetRow['user_id'], ['password' => $hashedPassword]);

        // Marcar token como usado
        $stmt = $pdo->prepare("UPDATE password_resets SET used = 1 WHERE id = ?");
        $stmt->execute([$resetRow['id']]);

        $_SESSION['success'] = 'Contraseña restablecida correctamente. Ahora puedes iniciar sesión.';
        header('Location: /login');
        exit;
    }
}
