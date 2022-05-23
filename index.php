<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dataBase = "projeto_ti";

$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    echo "Cant create database";
}

try
{
    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS projeto_TI";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully";

    } else {
        echo "Error creating database: " . $conn->error;
    }
}
catch (Exception $e)
{
    echo "Error creating database<scritpt>alert('DB criada anteriormente')</script>";
}

$conn->close();


try
{
    $conn = new mysqli($servername, $username, $password, $dataBase);
    if ($conn->connect_error)
    {
        echo "cant create table in database";
    }
    $sql = "SHOW TABLES IN `" . $dataBase . "`";
    if ($conn->query($sql) === TRUE) {
        echo "Table doesn't exists";
        $sql = "CREATE TABLE users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user VARCHAR(30) NOT NULL,
            passwd VARCHAR(500) NOT NULL,
            permissionLevel INT UNSIGNED
            )";


        if ($conn->query($sql) === TRUE) {
            echo "Table created successfully";
        } else {
            echo "Error creating table: " . $conn->error;
        }
    } else {
        echo "Table exists: " . $conn->error;

    }
}catch (Exception $e)
{
    echo "Error creating table";
}

$sql_size = "SELECT COUNT(*) FROM users";
if ($sql_size == 0) {
    echo "size = 0";
    $sql = "INSERT INTO users (user, passwd, permissionLevel)
VALUES ('user', '" . hash("sha256", "password") . "', 2)";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql = "INSERT INTO users (user, passwd, permissionLevel)
VALUES ('admin', '" . hash("sha256", "root") . "', 1)";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
echo "fim";
$conn->close();
header("refresh:0;login.php");
?>