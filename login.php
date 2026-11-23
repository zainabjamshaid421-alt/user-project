<?php
require __DIR__ . '/db.php';
use Illuminate\Database\Capsule\Manager as Capsule;
echo "email: ";
$email = trim(fgets(STDIN));
echo "password: ";
$password = trim(fgets(STDIN));
$user = Capsule::table('users')->where('email', $email)->first();
if ($user && password_verify($password, $user->password)) {
    echo "Login successful. Welcome, " . $user->name . "!\n";
} else {
    echo "Invalid email or password.\n";
}