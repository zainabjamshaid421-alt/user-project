<?php
require __DIR__ . '/vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as Capsule;
$users = Capsule::table('users')->get();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forms</title>
    <style>
        table{border-collapse: collapse;width: 80%; margin:auto;}
        th,td{border: 1px solid black;padding:10px; text-align: center;}
        th{background: lightblue;}
        </style>
</head>
<body>
    <h2 style="text-align: center;">All Users - HTML Table</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user->id; ?></td>
            <td><?php echo $user->name; ?></td>
            <td><?php echo $user->email; ?></td>
            <td><?php echo $user->created_at; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br><center><a href="index.html">Go back</a></center>
    <a href="login.html" style="position: absolute; top: 10px; right: 10px;">Login</a>
    
</body>
</html>