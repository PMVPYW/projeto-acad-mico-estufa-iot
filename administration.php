<!DOCTYPE html>
<html lang='pt'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <title>Admin</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
        <link rel="stylesheet" type="text/css" href="style.css">
	<style>
		body {
  		background-size: cover;
		}
		.card
		{
			background-color: rgba(255, 255, 255, 0.8);
		}
		h1 {
		color: white;
		text-shadow: 2px 2px 4px #000000;
  }
	</style>
    </head>
    <body>
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $dataBase = "projeto_ti";
            session_start();
            if (!isset($_SESSION['username']))
				{
					header("refresh: 5; url:index.php"); 
					header("refresh:0;index.php");
				}
            if ($_SESSION['permissionLevel'] != 1)
            {
                echo "<script>alert('Acesso negado!')";
                header("refresh:0;dashboard.php");
            }
            if(isset($_POST['newUser']) && isset($_POST['newPassword']) && isset($_POST['ComfirmPassword']))
            {
                if ($_POST['newPassword'] != $_POST['ComfirmPassword'])
                {
                    echo "<script>alert('As passwords não coincidem');</script>";
                }
                else
                {
                    $conn = new mysqli($servername, $username, $password, $dataBase);
                    // Check connection
                    if ($conn->connect_error) {
                        echo "<script>alert('Infelizmente não é possivel conectar-se á base de dados')</script>";
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $sql = "SELECT user, passwd, permissionLevel FROM users";
                    $result = $conn->query($sql);
                    $exists = false;
                    while($row = $result->fetch_assoc()) 
                    {
                        if ($_POST['newUser'] == $row['user'])
                        {
                            if (hash("sha256", $_POST['newPassword']) == $row['passwd'])
                            {
                                $exists = true;
                            }
                        }
                    }
                    if ($exists == true)
                    {
                        echo "<script>alert('Utilizador já existe');</script>";
                    }
                    else
                    {
                        $sql = "INSERT INTO users (user, passwd, permissionLevel)
VALUES ('" . $_POST['newUser'] . "' , '" . hash("sha256", $_POST['newPassword']) . "', " . $_POST['PermissionLevel'] . ")";
                        if ($conn->query($sql) === TRUE) {
                            echo "<script>alert('Utilizador criado com sucesso');</script>";
                        } else {
                            echo "<script>alert('Erro ao criar utilizador');</script>";
                        }
                    }
                }
            }
        ?>


<br>
	<!--nav-bar-->
	<div class="container text-center">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="#">Dashboard EI-TI</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" id="navbarScroll">
		      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                <li class="nav-item">
					<a class="nav-link" aria-current="page" href="dashboard.php">Sensores</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" aria-current="page" href="atuadores.php">Atuadores</a>
				</li>   
                <li class="nav-item">
					<a class="nav-link" aria-current="page" href="generalHistory.php">Histórico Geral</a>
				</li>
		      </ul>
		     	<a href="logout.php" class="btn btn-primary">Logout</a>
		    </div>
		  </div>
		</nav>
	</div>


        <div class="container text-center">
            <form class="login-form" method="POST">
                <b>
		    	<label for="newUser" class="form-label">Novo Utilizador</label><br>
				</b>
                <input type="text" name="newUser" class="form-control" placeholder="Novo Utilizador" required>
                <b><br>
		    	<label for="Password" class="form-label">Password</label>
				</b><br>
                <input type="password" name="newPassword" class="form-control" id="pass0" placeholder="Nova Password" required><br>
                <b>
                <label for="ConfirmsPassword" class="form-label">Comfirmar Password</label>
				</b><br>
                <input type="password" name="ComfirmPassword" class="form-control" id="pass1" placeholder="Nova Password" required>
                <br>
                <b>
                <label for="PermissionLevel" class="form-label">Nivel de Permissão</label><br>
                </b>
                <input type="number" name="PermissionLevel" class="form-control" min="1" max="3" placeholder="Nivel de permissão" required>
                <br><br>
                <input type="submit" value="Criar Utilizador" class="btn-primary btn">
            </form>
        </div>
        <script src="controlPasswd.js"></script>
    </body>
</html>