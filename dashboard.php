<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <!--
	<meta http-equiv="refresh" content="5">
	-->
	<title>Plataforma IoT</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
	<style>
		body {
  		background-size: cover;
		}
		.card
		{
			background-color: rgba(255, 255, 255, 0.8);
		}
	</style>
</head>
<body>
	<!--DASHBOARD-->
	<?php 
		session_start();
		if (!isset($_SESSION['username']))
		{
            header("refresh:0;login.php");
		}
		date_default_timezone_set("Europe/Lisbon");
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dataBase = "projeto_ti";
    $conn = new mysqli($servername, $username, $password, $dataBase);
    if ($conn->connect_error) {
        echo "Infelizmente não é possivel conectar-se á base de dados";
        die("Connection failed: " . $conn->connect_error);
    }
        function lerValor($conn, $servername, $username, $password, $dataBase, $nome)
        {
            $sql = " SELECT valor FROM ". $nome ." ORDER By id DESC LIMIT 1";
            $result = $conn->query($sql) or die($conn->error);
            while($row = $result->fetch_assoc())
            {
                return $row['valor'];
            }

        }


		//obtenção de dados dos sensores
		$valor_temperatura = lerValor($conn, $servername, $username, $password, $dataBase, "temperatura");
		$hora_temperatura = file_get_contents("api/files/temperatura/hora.txt");
		$nome_temperatura = file_get_contents("api/files/temperatura/nome.txt");

		$valor_luminosidade = lerValor($conn, $servername, $username, $password, $dataBase, "luminosidade");
		$hora_luminosidade = file_get_contents("api/files/luminosidade/hora.txt");
		$nome_luminosidade = file_get_contents("api/files/luminosidade/nome.txt");

		$valor_humidade = lerValor($conn, $servername, $username, $password, $dataBase, "humidade");
		$hora_humidade = file_get_contents("api/files/humidade/hora.txt");
		$nome_humidade = file_get_contents("api/files/humidade/nome.txt");

		$nome_bateria = file_get_contents("api/files/bateria/nome.txt");
		$valor_bateria = lerValor($conn, $servername, $username, $password, $dataBase, "bateria");
		$hora_bateria = file_get_contents("api/files/bateria/hora.txt");

		$nome_agua = file_get_contents("api/files/Deposito_Agua/nome.txt");
		$valor_agua = lerValor($conn, $servername, $username, $password, $dataBase, "Deposito_Agua");
		$hora_agua = file_get_contents("api/files/Deposito_Agua/hora.txt");
    $conn->close();
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
			  	<?php
					if ($_SESSION['permissionLevel'] == 1)
					{
						echo '<li class="nav-item"><a class="nav-link" aria-current="page" href="administration.php">Admin</a></li> ';
					}  
				?>
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
	
	<br>
	<div class="container">
		<div class="card">
			<div class="card-body">
				<img src="imagens/misc/estg.png" class="float-end" style="width: 300px; " alt="IPL">
				<h1>Servidor IoT</h1>
				<br><p>Bem vindo <b>Utilizador <?php echo $_SESSION['username'] . "<br>Nivel de permissão: " . $_SESSION['permissionLevel'];?></b></p>
				<br><small>Tecnologias de Internet - Engenharia Informática</small>
				<small id="horas" class="float-end">
					<?php
						echo date('d/m/Y H:i:s');
					?>
				</small>
			</div>
		</div>
	</div>
	<br>
	<!--cartões-sensores-->
	<div class="container text-center">
		<div class="row">
		<div class="col-sm-4">
				<div class="card">
					<div class="card-header">
						<h3 id="luminosidade">
							<?php echo $nome_luminosidade . ": " . $valor_luminosidade; ?>%
						</h3>
					</div>
					<div class="card-body">
						<img src="imagens/sensores/dia.png" alt="Luminosidade">
					</div>
					<div class="card-footer">
						<p id="luminosidade_hora"><b>Atualização: </b><?php echo $hora_luminosidade; ?> - <a href="historico.php?nome=luminosidade">Histórico</a></p>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-header">
						<h3 id="temperatura">
							<?php echo $nome_temperatura . ": " . $valor_temperatura; ?>º
						</h3>
					</div>
					<div class="card-body">
						<img src="imagens/sensores/temperature.png" alt="Temperatura">
					</div>
					<div class="card-footer">
						<p id="temperatura_hora"><b>Atualização: </b><?php echo $hora_temperatura; ?> - <a href="historico.php?nome=temperatura">Histórico</a></p>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-header">
						<h3 id="humidade">
							<?php echo $nome_humidade . ": " . $valor_humidade; ?>%
						</h3>
					</div>
					<div class="card-body">
						<img src="imagens/sensores/humidade.png" alt="humidade">
					</div>
					<div class="card-footer">
						<p id="humidade_hora"><b>Atualização: </b><?php echo $hora_humidade; ?> - <a href="historico.php?nome=humidade">Histórico</a></p>
					</div>
				</div>
			</div>
			<br><br><br><br><br><br><br><br><br><br><br><br><br>
			<div class="col-sm-6">
				<div class="card">
					<div class="card-header">
						<h3 id="agua">
							<?php echo $nome_agua . ": " . $valor_agua; ?>L
						</h3>
					</div>
					<div class="card-body">
						<img src="imagens/sensores/agua.png" alt="Agua">
					</div>
					<div class="card-footer">
						<p id="agua_hora"><b>Atualização: </b><?php echo $hora_agua; ?> - <a href="historico.php?nome=Deposito_Agua">Histórico</a></p>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="card">
					<div class="card-header">
						<h3 id="bateria">
							<?php echo $nome_bateria . ": " . $valor_bateria; ?>%
						</h3>
					</div>
					<div class="card-body">
						<img src="imagens/sensores/bateria.png" alt="Bateria">
					</div>
					<div class="card-footer">
						<p id="bateria_hora"><b>Atualização: </b><?php echo $hora_bateria; ?> - <a href="historico.php?nome=bateria">Histórico</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br>
	<!--tabela-sensores-->
	<div class="container text-center">
		<div class="card">
			<div class="card-header">
			<b>Tabela Sensores</b>
			</div>
			<div class="card-body">
				
				<table class="table">
				  <thead>
				    <tr>
				      <th scope="col">Tipo de Dispositivo IoT</th>
				      <th scope="col">Valor</th>
				      <th scope="col">Data de atualização</th>
				      <th scope="col">Estado</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr>
				      <th scope="row">Sensor de Luminusidade</th>
				      <td id="luminosidade_label">
						<?php 
							echo $valor_luminosidade;
					  	?>%
						</td>
				      <td id="luminosidade_hora_label">
					  <?php 
							echo $hora_luminosidade;
					  	?>
					  </td>
				      <td id="luminosidade_badge">
						  <?php
						  	//alteração do "badge" na tabela"
						 	if ($valor_luminosidade >= 60)
							 {
								echo '<span class="badge rounded-pill bg-success">Alto</span></td>';
							 }
							elseif ($valor_luminosidade >=30)
							{
								echo '<span class="badge rounded-pill bg-warning">Médio</span></td>';
							}
							else
							{
								echo '<span class="badge rounded-pill bg-danger">Baixo</span></td>';
							}

						  ?>
				    </tr>
				    <tr>
				      <th scope="row">Sensor de Temperatura</th> 
				      <td id="temperatura_label"><?php echo $valor_temperatura; ?>º</td>
				      <td id="temperatura_hora_label"><?php echo $hora_temperatura; ?></td>
				      <td id="temperatura_badge">
					  <?php
					  		//alteração do "badge" na tabela"
						 	if ($valor_temperatura >= 25)
							 {
								echo '<span class="badge rounded-pill bg-danger">Alto</span></td>';
							 }
							elseif ($valor_temperatura >=15)
							{
								echo '<span class="badge rounded-pill bg-success">Ideal</span></td>';
							}
							else
							{
								echo '<span class="badge rounded-pill bg-danger">Baixo</span></td>';
							}

						  ?>
				    </tr>
				    <tr>
				      <th scope="row">Sensor de Humidade</th>
				      <td id="humidade_label">
					  <?php 
							echo $valor_humidade;
					  	?>%
					  </td>
				      <td id="humidade_hora_label">
					  <?php 
							echo $hora_humidade;
					  	?>
					  </td>
				      <td id="humidade_badge">
					  <?php
					  		//alteração do "badge" na tabela"
						 	if ($valor_humidade >= 60)
							 {
								echo '<span class="badge rounded-pill bg-success">Alto</span></td>';
							 }
							elseif ($valor_humidade >=30)
							{
								echo '<span class="badge rounded-pill bg-warning">Médio</span></td>';
							}
							else
							{
								echo '<span class="badge rounded-pill bg-danger">Baixo</span></td>';
							}

						  ?>

				    </tr>
				    <tr>
				      <th scope="row">Nivel de Água</th>
				      <td id="agua_label">
					  <?php 
							echo $valor_agua;
					  	?>%
					  </td>
				      <td id="agua_hora_label">
					  <?php 
							echo $hora_agua;
					  	?>
					  </td>
				      <td id="agua_badge">
					  <?php
					  		//alteração do "badge" na tabela"
						 	if ($valor_agua >= 60)
							 {
								echo '<span class="badge rounded-pill bg-success">Alto</span></td>';
							 }
							elseif ($valor_agua >=30)
							{
								echo '<span class="badge rounded-pill bg-warning">Médio</span></td>';
							}
							else
							{
								echo '<span class="badge rounded-pill bg-danger">Baixo</span></td>';
							}

						  ?> 
				    </tr>
					<tr>
				      <th scope="row">Nivel de Bateria</th>
				      <td id="bateria_label">
					  <?php 
							echo $valor_bateria;
					  	?>%
					  </td>
				      <td id="bateria_hora_label">
					  <?php 
							echo $hora_bateria;
					  	?>
					  </td>
				      <td id="bateria_badge">
					  <?php
					  		//alteração do "badge" na tabela"
						 	if ($valor_bateria >= 50)
							 {
								echo '<span class="badge rounded-pill bg-success">Alto</span></td>';
							 }
							elseif ($valor_bateria >=20)
							{
								echo '<span class="badge rounded-pill bg-warning">Médio</span></td>';
							}
							else
							{
								echo '<span class="badge rounded-pill bg-danger">Baixo</span></td>';
							}

						  ?> 
					  </tr>
				  </tbody>
				</table>

			</div>
		</div>
	</div>
	<script src="horas.js"></script>
<script>
    <?php
    $ip = $_SERVER["SERVER_ADDR"];
    if ($ip == '::1')
    {
        $ip = "localhost";
    }
    echo "var ip = '". $ip . "';";
    ?>




    function set(url, nome, symbol, id)
    {
        var x = document.getElementById(id)
        var HTTP = new XMLHttpRequest();
        HTTP.open( "GET", url); // false for synchronous request
        HTTP.send();
        HTTP.onload =function()
        {
            if(HTTP.status == 200)
            {
                var vars = HTTP.responseText.split(";");
                x.innerHTML = nome +": " + vars[0] + symbol;
                document.getElementById(id.concat("_label")).innerHTML = vars[0].concat(symbol);
                if (nome == "Deposito Agua")
                {
                    nome = "Deposito_Agua";
                }
                document.getElementById(id.concat("_hora")).innerHTML = "<b>Atualização: </b>" + vars[1] + ' - <a href=\"historico.php?nome='+nome+'\">Histórico</a>';
                document.getElementById(id.concat("_hora_label")).innerHTML = vars[1];
                console.log("response: " + HTTP.responseText);
                switch (id) {
                    case 'luminosidade':
                    case 'humidade':
                    case 'agua':
                        if (vars[0] >= 60)
                        {
                            document.getElementById(id+"_badge").innerHTML = '<span class="badge rounded-pill bg-success">Alto</span></td>';
                        }
                        else if(vars[0]>=30)
                        {
                            document.getElementById(id+"_badge").innerHTML = '<span class="badge rounded-pill bg-warning">Médio</span></td>'
                        }
                        else
                        {
                            document.getElementById(id+"_badge").innerHTML = '<span class="badge rounded-pill bg-danger">Baixo</span></td>'
                        }
                        break;
                    case 'temperatura':
                        if (vars[0] >= 25)
                        {
                            document.getElementById("temperatura_badge").innerHTML = '<span class="badge rounded-pill bg-danger">Alto</span></td>';
                        }
                        else if(vars[0]>=15)
                        {
                            document.getElementById("temperatura_badge").innerHTML = '<span class="badge rounded-pill bg-success">Ideal</span></td>'
                        }
                        else
                        {
                            document.getElementById("temperatura_badge").innerHTML = '<span class="badge rounded-pill bg-danger">Baixo</span></td>'
                        }
                        break;
                    case 'bateria':
                        if (vars[0] >= 50)
                        {
                            document.getElementById(id+"_badge").innerHTML = '<span class="badge rounded-pill bg-success">Alto</span></td>';
                        }
                        else if(vars[0]>=20)
                        {
                            document.getElementById(id+"_badge").innerHTML = '<span class="badge rounded-pill bg-warning">Médio</span></td>'
                        }
                        else
                        {
                            document.getElementById(id+"_badge").innerHTML = '<span class="badge rounded-pill bg-danger">Baixo</span></td>'
                        }
                        break;

                }
            }
            else
            {
                console.log("status");
                console.log(HTTP.status);
                console.log("response: " + vars[0]);
            }

        }
    }

    function handle()
    {
        var hum = document.getElementById("humidade").innerHTML.replace("Luminosidade: ", "").replace("%", )
    }

    setInterval(function()
    {
        var url = "http://" + ip + "/projeto_ti%20-%20SQL/api/api.php?nome=luminosidade"
        set(url, "Luminosidade", "%", "luminosidade");
        var url = "http://" + ip + "/projeto_ti%20-%20SQL/api/api.php?nome=temperatura"
        set(url, "temperatura", "º", "temperatura");
        var url = "http://" + ip + "/projeto_ti%20-%20SQL/api/api.php?nome=humidade"
        set(url, "humidade", "%", "humidade");
        var url = "http://" + ip + "/projeto_ti%20-%20SQL/api/api.php?nome=Deposito_Agua"
        set(url, "Deposito Agua", "L", "agua");
        var url = "http://" + ip + "/projeto_ti%20-%20SQL/api/api.php?nome=bateria"
        set(url, "bateria", "%", "bateria");

    }, 1000);
</script>
</body>
</html>