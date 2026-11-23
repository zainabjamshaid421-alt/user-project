<?php
require __DIR__ . '/db.php';
use Illuminate\Database\Capsule\Manager as Capsule;
$name = trim($_POST['name']??'');
$email = trim($_POST['email']??'');
$password = trim($_POST['password']??'');
if (empty($name) || empty($email) || empty($password)) {
    echo "Please fill in all fields.";
    echo '<a href="index.html">Go back</a>';}
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        echo '<a href="index.html">Go back</a>';
    } if (strlen($password) < 6) {
        echo "Password must be at least 6 characters long.";
        echo '<a href="index.html">Go back</a>';
    } if (Capsule::table('users')->where('email', $email)->exists()) {
        echo "Email already exists.";
        echo '<a href="index.html">Go back</a>';
    }
    Capsule::table('users')->insert([
        'name' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ]);
    echo "Registration successful!";
    echo '<a href="login.html">Go to Login</a>';