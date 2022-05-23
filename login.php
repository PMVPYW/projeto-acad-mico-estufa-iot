<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<div class="container">
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dataBase = "projeto_ti";
    /*
        if ( isset($_GET['username']))
        {
            echo "O username inserido foi: " . $_GET['username'] . "<br>";
        }
        if ( isset($_GET['password']))
        {
            echo "A password inserida foi: " . $_GET['password'] . "<br>";
        }
    */
    if ( isset($_POST['username']) && isset($_POST['password']))
    {
        $conn = new mysqli($servername, $username, $password, $dataBase);
        // Check connection
        if ($conn->connect_error) {
            echo "<script>alert('Infelizmente não é possivel conectar-se á base de dados')</script>";
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT user, passwd, permissionLevel FROM users";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            if ($_POST['username'] == $row['user'])
            {
                if (hash("sha256", $_POST['password']) == $row['passwd'])
                {
                    echo "Login efetuado com sucesso!";
                    session_start();
                    $_SESSION["username"]=$_POST['username'];
                    $_SESSION['permissionLevel'] = $row['permissionLevel'];
                    echo "<h1>Autenticado</h1>";
                    header("refresh:0;dashboard.php");
                }
            }
        }
    }

    ?>
    <form class="login-form" method="POST">
        <div class="text-center">
            <img src="imagens/misc/estg.png" alt="estg" style="width: 90%;">
        </div>

        <br>
        <div class="mb-3">
            <b>
                <label for="username" class="form-label">Username</label>
            </b>
            <input type="text" class="form-control" id="username" aria-describedby="username" placeholder="nome de utilizador" name="username" required>
        </div>
        <div class="mb-3">
            <b>
                <label for="password" class="form-label">Password</label>
            </b>
            <input type="password" class="form-control" id="password" placeholder="palavra-passe" name="password" required>
        </div>
        <div class="mb-3 form-check">
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Submeter</button>
        </div>
    </form>
</div>
</body>
</html>