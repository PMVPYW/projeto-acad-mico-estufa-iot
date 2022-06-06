<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dataBase = "projeto_ti";

function createTable($conn, $tableName, $servername, $username, $password, $dataBase)
{
    try
    {
        $sql = "'select 1 from `". $tableName ."` LIMIT 1'";
        if ($conn->query($sql) !== FALSE) {
            echo "<br>Table exists: " . $conn->error;
        } else {
            echo "Table doesn't exists";
            $sql = "CREATE TABLE " . $tableName . " (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            valor VARCHAR(20) NOT NULL,
            hora VARCHAR(100) NOT NULL
            )";


            if ($conn->query($sql) === TRUE) {
                echo "Table created successfully";
            } else {
                echo "Error creating table: " . $conn->error;
            }

        }
    }catch (Exception $e)
    {
        echo "Error creating table";
    }
}


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
        $sql = "CREATE TABLE users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user VARCHAR(30) NOT NULL,
            passwd VARCHAR(500) NOT NULL,
            permissionLevel INT UNSIGNED
            )";


        if ($conn->query($sql) === TRUE) {
            echo "Table users created successfully";
        } else {
            echo "Error creating users table: " . $conn->error;
        }
}catch (Exception $e)
{
    echo "Error creating users table" . $e;
}

$sql_size = "SELECT * FROM users";
$result = $conn->query($sql_size);
$sql_size = 0;
while($row = $result->fetch_assoc())
{
    print_r($row);
    if (strlen($row['user']) > 0)
    {
        $sql_size++;
    }
}

echo "<br><br><br>users: " . $sql_size . "<br><br><br>";
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
    echo "user inserted<br>";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


/*Base de dados API*/
$folders = scandir("api/files");
foreach ($folders as $folder)
{
    if ($folder != "." and $folder != "..")
    {
        echo $folder;
        createTable($conn, $folder, $servername, $username, $password, $dataBase);
    }

}



echo "fim";
$conn->close();
header("refresh:0;login.php");
?>