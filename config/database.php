<?php
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('BASE', 'serverlist');


try
{
    $handler = new PDO('mysql:dbname=' . BASE . ';host=' . HOST, USER, PASS, [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]);
    // echo 'Connection successful';
}
catch (PDOException $e)
{
    echo 'Connection failed: ' . $e->getMessage();
}