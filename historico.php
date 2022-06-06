<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="refresh" content="5">
	<title>Histórico</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
	<style>
		.scroller {
  overflow:auto;  
  margin-top:20px;
	  }
	</style>
</head>
<body>
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
		      </ul>
		     	<a href="logout.php" class="btn btn-primary">Logout</a>
		    </div>
		  </div>
		</nav>
	</div>
    <br><br>
                
            <?php
				session_start();
				if (!isset($_SESSION['username']))
				{
                    header("refresh:0;login.php");
				}
				if ($_SESSION['permissionLevel'] > 2)
            	{
					echo "<script>alert('Acesso negado!')</script>";
					header("refresh:0;dashboard.php");
            	}
				else
				{
					if (isset($_GET['nome']))
					{
						if (file_exists("api/files/" . $_GET['nome'] . "/log.txt"))//verificação de existência dos ficheiros
						{
                            $servername = "localhost";
                            $username = "root";
                            $password = "root";
                            $dataBase = "projeto_ti";
                            $conn = new mysqli($servername, $username, $password, $dataBase);
                            if ($conn->connect_error) {
                                echo "Infelizmente não é possivel conectar-se á base de dados";
                                die("Connection failed: " . $conn->connect_error);
                            }
                            function lerLog($conn, $servername, $username, $password, $dataBase, $nome)
                            {
                                $sql = " SELECT valor, hora FROM ". $nome ." ORDER By id DESC";

                                $result = $conn->query($sql) or die($conn->error);
                                return $result;
                                /*while($row = $result->fetch_assoc())
                                {
                                    return $row['valor'];
                                }*/

                            }
							echo "<div class='text-center'>
							<h1>Histórico:" . $_GET['nome'] . "</h1>
						</div>";

							echo '<div class="container text-center card scroller" style="max-height: 700px">
							<table class="table scroller" style="height: 90%">
								<thead>
									<tr>
									<th scope="col">Valor</th>
									<th scope="col">Data de atualização</th>
									</tr>
								</thead>
								<tbody>';//criação da tabela
							#$log = array_reverse(explode(PHP_EOL, file_get_contents("api/files/" . $_GET['nome'] . "/log.txt")));//leitura de log, separação em array e inversão do mesmo
							$log = lerLog($conn, $servername, $username, $password, $dataBase, $_GET['nome']);
                            foreach($log as $report)
							{
									echo '<tr><td>' . $report['valor'] . '</td><td>' . $report['hora'] . '</td></tr>';
							}
							$conn->close();
						}
					}
				}
            ?>
            </tbody>
        </table>
    </div>


</body>
</html>