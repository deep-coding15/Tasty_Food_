<?php
function getConnectionToDatabase()
{
    try {
        $dbname = "openclassroom_blog_avbn";
        $servername = "localhost";
        $username = "root";
        $password = "";

        $database = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        return $database;
    } catch (PDOException $e) {
        die('Erreur: ' . $e->getMessage());
    }
}