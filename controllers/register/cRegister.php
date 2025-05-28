<?php

require_once('./config/database.php');
require_once('./models/User.php'); 
session_start();

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    
    if (empty($username)) {
        $errors[] = "El nombre de usuario es obligatorio.";
    } elseif (strlen($username) < 4) {
        $errors[] = "El usuario debe tener al menos 4 caracteres.";
    }

    if (empty($password)) {
        $errors[] = "La contraseña es obligatoria.";
    } elseif (strlen($password) < 6) {
        $errors[] = "La contraseña debe tener al menos 6 caracteres.";
    }

    if (empty($email)) {
        $errors[] = "El correo electrónico es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El correo electrónico no es válido.";
    }

    if (!empty($phone) && !preg_match('/^[0-9+\s()-]*$/', $phone)) {
        $errors[] = "El número de teléfono contiene caracteres inválidos.";
    }

    if (empty($errors)) {
        try {
            $database = new Database();
            $pdo = $database->getConnection();

            $user = new User($pdo);

             $user->username = $username;
            $user->email = $email;

            if ($user->userExists($username, $email)) {
                $errors[] = "El nombre de usuario o correo ya está registrado.";
            } else {
               
               
                $user->password = $password;
                $user->name = $name ?: null;               
                $user->phone = $phone ?: null;

                if ($user->register()) {
                    $success = true;
                    
                    header("Location: index.php?acc=Register&register=success");
                    exit;
                } else {
                    $errors[] = "No se pudo registrar el usuario.";
                }
            }
        } catch (PDOException $e) {
            $errors[] = "Error en la base de datos: " . $e->getMessage();
        }
    }
}

require_once('./views/register/vRegister.php');
