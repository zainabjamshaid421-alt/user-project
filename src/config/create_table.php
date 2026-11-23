<?php
require __DIR__ . '/db.php';
use Illuminate\Database\Capsule\Manager as Capsule;
Capsule::schema()->dropIfExists('users');
Capsule::schema()->create('users', function ($table) {
    $table->increments('id');
    $table->string('username')->unique();
    $table->string('email')->unique();
    $table->string('password');
    $table->timestamps();
});
echo "Table 'users' created successfully.";