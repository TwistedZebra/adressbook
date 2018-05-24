<?php

session_start();


    $host = 'localhost';
    $database = 'contacts';
    $username = 'root';
    $password = '';

    try {
        $connection = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }
    catch(PDOException $e) {
        dd($e->getMessage());
    }


// load all the base functions
function dd($text)
{
    if(is_array($text) || is_object($text)) {
        var_dump($text);
        die();
    }
    else {
        die($text);
    }
}