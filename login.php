<?php
session_start();
require __DIR__ . '/db.php';
use Illuminate\Database\Capsule\Manager as Capsule;
$email = trim($_POST['email']);
$password = trim($_POST['password']);
if (empty($email) || empty($password)) {
    echo "Please fill in all fields.";
}if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format.";
} else {
    $user = Capsule::table('users')->where('email', $email)->first();
    if (!$user || !password_verify($password, $user->password)) {
        echo "Invalid email or password.";
    } else {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->name;

        header("Location:users.php");
        exit();
    }
}