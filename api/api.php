<?php
    header('content-type: text/html; charset=utf-8');
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dataBase = "projeto_ti";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_POST['username']) && !isset($_POST['password']))
        {
            print_r($_POST);
            die("login required");
        }
        $conn = new mysqli($servername, $username, $password, $dataBase);
        if ($conn->connect_error) {
            echo "Infelizmente não é possivel conectar-se á base de dados";
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT user, passwd, permissionLevel FROM users";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) 
        {
            if ($_POST['username'] == $row['user'])
            {
                if (hash("sha256", $_POST['password']) == $row['passwd'])
                {
                    if ($row['permissionLevel'] == 1)
                    {
                        echo "recebido um POST";
                        print_r($_POST);
                        if (isset($_POST['valor']) && isset($_POST['hora']) && isset($_POST['nome']))
                        {
                            $sql = "INSERT INTO " . $_POST['nome'] . " (valor, hora)
VALUES ('" . $_POST['valor'] . "', '" . $_POST['hora'] . "')";
                            if ($conn->query($sql) === TRUE) {
                                echo "New record created successfully";
                            } else {
                                echo "Error: " . $sql . "<br>" . $conn->error;
                            }
                            file_put_contents("files/" . $_POST['nome'] . "/valor.txt", $_POST['valor']);
                            file_put_contents("files/" . $_POST['nome'] . "/hora.txt", $_POST['hora']);
                            file_put_contents("files/" . $_POST['nome'] . "/nome.txt", $_POST['nome']);
                            file_put_contents("files/" . $_POST['nome'] . "/log.txt", $_POST['hora'] . ";" . $_POST['valor'] . PHP_EOL, FILE_APPEND);
                        }
                        else
                        {
                            die ("wrong number of arguments!<br>valor: required<br>hora: required<br>nome: required");
                        }
                    }
                    else
                    {
                        die ("Wrong permission Level!");
                    }
                    
                }
                else
                {
                    die ("wrong password!");
                }
            }
        }   
    }
    elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['nome']))
        {
            if (file_exists("files/" . $_GET['nome'] . "/valor.txt"))
            {
                $conn = new mysqli($servername, $username, $password, $dataBase);
                if ($conn->connect_error) {
                    echo "Infelizmente não é possivel conectar-se á base de dados";
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql = " SELECT valor, hora FROM ". $_GET['nome'] ." ORDER By id DESC LIMIT 1";
                $result = $conn->query($sql) or die($conn->error);
                while($row = $result->fetch_assoc())
                {
                    echo $row['valor'] . ";" . $row['hora'];
                }
            }

                    //echo file_get_contents("files/" . $_GET['nome'] . "/valor.txt");

            else
            {
                http_response_code(403);
            }
        }
        else
        {
            http_response_code(400);
        }
    }

    else
    {
        echo "método não é permitido";
    }

    
?>