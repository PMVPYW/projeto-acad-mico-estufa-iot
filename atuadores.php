<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="refresh" content="5">
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
		h1 {
		color: white;
		text-shadow: 2px 2px 4px #000000;
  }
	</style>
</head>
<body>
	<!--ATUADORES-->
	<?php 
		session_start();
		if (!isset($_SESSION['username']))
		{
			header("refresh: 5; url:index.php"); 
			die("Acesso Restrito");
		}

		$valor_AC = file_get_contents("api/files/AC/valor.txt");
		$hora_AC = file_get_contents("api/files/AC/hora.txt");
		$log_AC = file_get_contents("api/files/AC/log.txt");
		$nome_AC = file_get_contents("api/files/AC/nome.txt");

		$valor_iluminacao = file_get_contents("api/files/iluminação/valor.txt");
		$hora_iluminacao = file_get_contents("api/files/iluminação/hora.txt");
		$log_iluminacao = file_get_contents("api/files/iluminação/log.txt");
		$nome_iluminacao = file_get_contents("api/files/iluminação/nome.txt");

		$valor_irrigacao = file_get_contents("api/files/irrigação/valor.txt");
		$hora_irrigacao = file_get_contents("api/files/irrigação/hora.txt");
		$log_irrigacao = file_get_contents("api/files/irrigação/log.txt");
		$nome_irrigacao = file_get_contents("api/files/irrigação/nome.txt");

		$nome_pulverizador = file_get_contents("api/files/Pulverizador_Fertilizante/nome.txt");
		$valor_pulverizador = file_get_contents("api/files/Pulverizador_Fertilizante/valor.txt");
		$log_pulverizador = file_get_contents("api/files/Pulverizador_Fertilizante/log.txt");
		$hora_pulverizador = file_get_contents("api/files/Pulverizador_Fertilizante/hora.txt");

		$nome_seguidorSolar = file_get_contents("api/files/seguidor_Solar/nome.txt");
		$valor_seguidorSolar = file_get_contents("api/files/seguidor_Solar/valor.txt");
		$log_seguidorSolar = file_get_contents("api/files/seguidor_Solar/log.txt");
		$hora_seguidorSolar = file_get_contents("api/files/seguidor_Solar/hora.txt");
		
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
					<a class="nav-link" aria-current="page" href="dashboard.php">Sensores</a>
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
	<!--cartão-sensores-->
	<div class="container text-center">
		<div class="row">
		<div class="col-sm-4">
				<div class="card">
					<div class="card-header">
						<h3>
							<?php echo $nome_iluminacao . ":" . $valor_iluminacao; ?>
						</h3>
					</div>
					<div class="card-body">
						<img src="imagens/atuadores/iluminação.png" alt="iluminação">
					</div>
					<div class="card-footer">
						<p><b>Atualização: </b><?php echo $hora_iluminacao; ?> - <a href="historico.php?nome=iluminação">Histórico</a></p>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-header">
						<h3>
							<?php echo $nome_AC . ":" . $valor_AC; ?>º
						</h3>
					</div>
					<div class="card-body">
						<img src="imagens/atuadores/AC.png" alt="AC">
					</div>
					<div class="card-footer">
						<p><b>Atualização: </b><?php echo $hora_AC; ?> - <a href="historico.php?nome=AC">Histórico</a></p>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-header">
						<h3>
							<?php echo $nome_irrigacao . ":" . $valor_irrigacao; ?>
						</h3>
					</div>
					<div class="card-body">
						<img src="imagens/atuadores/irrigação.png" alt="irrigação">
					</div>
					<div class="card-footer">
						<p><b>Atualização: </b><?php echo $hora_irrigacao; ?> - <a href="historico.php?nome=irrigação">Histórico</a></p>
					</div>
				</div>
			</div>
			<br><br><br><br><br><br><br><br><br><br><br><br><br>
			<div class="col-sm-6">
				<div class="card">
					<div class="card-header">
						<h3>
							<?php echo $nome_pulverizador . ":" . $valor_pulverizador; ?>
						</h3>
					</div>
					<div class="card-body">
						<img src="imagens/atuadores/pulverizador.png" alt="Pulverizador Fertilizante">
					</div>
					<div class="card-footer">
						<p><b>Atualização: </b><?php echo $hora_pulverizador; ?> - <a href="historico.php?nome=Pulverizador_Fertilizante">Histórico</a></p>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="card">
					<div class="card-header">
						<h3>
							<?php echo $nome_seguidorSolar . ":" . $valor_seguidorSolar; ?>º
						</h3>
					</div>
					<div class="card-body">
						<img src="imagens/atuadores/seguidorSolar.png" alt="Seguidor Solar">
					</div>
					<div class="card-footer">
						<p><b>Atualização: </b><?php echo $hora_seguidorSolar; ?> - <a href="historico.php?nome=seguidor_Solar">Histórico</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br>
	<!--tabela-atuadores-->
	<div class="container text-center">
		<div class="card">
			<div class="card-header">
			<b>Tabela Sensores</b>
			</div>
			<div class="card-body">
				
				<table class="table">
				  <thead>
				    <tr>
				      <th scope="col">Atuador</th>
				      <th scope="col">Valor</th>
				      <th scope="col">Data de atualização</th>
				      <th scope="col">Estado</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr>
				      <th scope="row">Iluminação</th>
				      <td>
						<?php 
							echo $valor_iluminacao;
					  	?>
						</td>
				      <td>
					  <?php 
							echo $hora_iluminacao;
					  	?>
					  </td>
				      <td>
						  <?php
						  	//alteração do "badge" na tabela"
						 	if ($valor_iluminacao == "Ligado")
							 {
								echo '<span class="badge rounded-pill bg-success">Ligado</span></td>';
							 }
							else
							{
								echo '<span class="badge rounded-pill bg-danger">Desligado</span></td>';
							}

						  ?>
				    </tr>
				    <tr>
				      <th scope="row">Ar Condicionado</th> 
				      <td><?php echo $valor_AC; ?>º</td>
				      <td><?php echo $hora_AC; ?></td>
				      <td>
					  <?php
						 	//alteração do "badge" na tabela"
							if ($valor_AC >= 25)
							 {
								echo '<span class="badge rounded-pill bg-danger">Alto</span></td>';
							 }
							elseif ($valor_AC >=15)
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
				      <th scope="row">Irrigação</th>
				      <td>
					  <?php 
							echo $valor_irrigacao;
					  	?>
					  </td>
				      <td>
					  <?php 
							echo $hora_irrigacao;
					  	?>
					  </td>
				      <td>
					  <?php
						 	//alteração do "badge" na tabela"
							if ($valor_irrigacao == "Ativo")
							 {
								echo '<span class="badge rounded-pill bg-success">Ativo</span></td>';
							 }
							else
							{
								echo '<span class="badge rounded-pill bg-danger">Inativo</span></td>';
							}

						  ?>
				    </tr>
				    <tr>
				      <th scope="row">Pulverizador de Fertilizante</th>
				      <td>
					  <?php 
							echo $valor_pulverizador;
					  	?>
					  </td>
				      <td>
					  <?php 
							echo $hora_pulverizador;
					  	?>
					  </td>
				      <td>
					  <?php
					  		//alteração do "badge" na tabela"
						 	if ($valor_pulverizador == "Ativo")
							 {
								echo '<span class="badge rounded-pill bg-success">Ativo</span></td>';
							 }
							else
							{
								echo '<span class="badge rounded-pill bg-danger">Inativo</span></td>';
							}

						  ?> 
				    </tr>
					<tr>
				      <th scope="row">Seguidor Solar</th>
				      <td>
					  <?php 
							echo $valor_seguidorSolar;
					  	?>º
					  </td>
				      <td>
					  <?php 
							echo $hora_seguidorSolar;
					  	?>
					  </td>
				      <td>
					  <?php
					  		//alteração do "badge" na tabela"
							echo '<span class="badge rounded-pill bg-success">' . $valor_seguidorSolar . 'º</span></td>';
						  ?> 
					  </tr>
				  </tbody>
				</table>
			</div>
		</div>
	</div>
	<script src="horas.js"></script>
</body>
</html>