<?php
global $pdo;

function dbConnect()
{
    $pdo = new PDO('mysql:host=localhost;dbname=courses;charset=utf8;', 'root', '');
    return $pdo;
}
