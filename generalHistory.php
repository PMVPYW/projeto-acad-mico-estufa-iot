<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="refresh" content="20">
	<title>Histórico</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
	<style>
		.scroller {
  overflow:auto;

	  }
	</style>
</head>
<body>
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
    else {
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
            $sql = " SELECT valor FROM " . $nome . " ORDER By id DESC LIMIT 10";

            $result = $conn->query($sql) or die($conn->error);
            $log = array();
            $data = array();
            foreach ($result as $value) {
                array_push($log, $value['valor']);
            }
            return $log;
        }

        function lerHora($conn, $servername, $username, $password, $dataBase, $nome)
        {
            $sql = " SELECT hora FROM " . $nome . " ORDER By id DESC LIMIT 10";

            $result = $conn->query($sql) or die($conn->error);
            $log = array();
            $data = array();
            foreach ($result as $value) {
                array_push($log, $value['hora']);
            }
            return $log;
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
					<a class="nav-link" aria-current="page" href="atuadores.php">Atuadores</a>
				</li>
		      </ul>
		     	<a href="logout.php" class="btn btn-primary">Logout</a>
		    </div>
		  </div>
		</nav>
	</div>
    <br><br>







	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>



	<div class="container text-center">
		<div class="row scroller" style="max-height: 355px" id="row">
		<script type="text/javascript">
			var w = window.innerHeight;
			var d = document.getElementById("row");
			d.style.maxHeight = (w*0.85)+"px";
		</script>
			<h1>Sensores</h1>
	  		<div class="col-md-4">
				  <div class="card graph">
				  <div class="card-header">
					  <h5>Temperatura</h5>
					</div>
					  <div class="card-body">
				  		<div id="TempChart" style="width:100%; height:250px;"></div>
						  </div>
				  </div>
			  </div>
			  <div class="col-md-4">
				  <div class="card graph">
				  <div class="card-header">
					  <h5>Luminosidade</h5>
					</div>
					  <div class="card-body">
				  		<div id="LumChart" style="width:100%; height:250px;"></div>
						  </div>
				  </div>
			  </div>
			  <div class="col-md-4">
				  <div class="card graph">
				  <div class="card-header">
					  <h5>Humidade</h5>
					</div>
					  <div class="card-body">
				  		<div id="HumidadeChart" style="width:100%; height:250px;"></div>
						  </div>
				  </div>
			  </div>
			  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			  <div class="col-md-6">
				  <div class="card graph">
				  <div class="card-header">
					  <h5>Depósito de água</h5>
					</div>
					  <div class="card-body">
				  		<div id="AguaChart" style="width:100%; height:250px;"></div>
						  </div>
				  </div>
			  </div>
			  <div class="col-md-6">
				  <div class="card graph">
				  <div class="card-header">
					  <h5>Bateria</h5>
					</div>
					  <div class="card-body">
				  		<div id="BatChart" style="width:100%; height:250px;"></div>
						  </div>
				  </div>
			  </div>
			  <h1>Atuadores</h1>
			  <div class="col-md-4">
				  <div class="card graph">
				  <div class="card-header">
					  <h5>Iluminação</h5>
					</div>
					  <div class="card-body">
				  		<div id="IlumChart" style="width:100%; height:250px;"></div>
						  </div>
				  </div>
			  </div>
			  <div class="col-md-4">
				  <div class="card graph">
				  <div class="card-header">
					  <h5>Ar Condicionado</h5>
					</div>
					  <div class="card-body">
				  		<div id="ACChart" style="width:100%; height:250px;"></div>
						  </div>
				  </div>
			  </div>
			  <div class="col-md-4">
				  <div class="card graph">
				  <div class="card-header">
					  <h5>Irrigação</h5>
					</div>
					  <div class="card-body">
				  		<div id="IrrigacaoChart" style="width:100%; height:250px;"></div>
						  </div>
				  </div>
			  </div>
			  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			  <div class="col-md-6">
				  <div class="card graph">
				  <div class="card-header">
					  <h5>Pulverizador Fertilizante</h5>
					</div>
					  <div class="card-body">
				  		<div id="FertilChart" style="width:100%; height:250px;"></div>
						  </div>
				  </div>
			  </div>
			  <div class="col-md-6">
				  <div class="card graph">
				  <div class="card-header">
					  <h5>Seguidor Solar</h5>
					</div>
					  <div class="card-body">
				  		<div id="SeguidorSolarChart" style="width:100%; height:250px;"></div>
						  </div>
				  </div>
			  </div>
		</div>
	</div>


	<script type="text/javascript">
google.charts.load('current',{packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
// Set Data
var data = google.visualization.arrayToDataTable([
  ['sensor', 'valor'],
  <?php
    $log = array_reverse(lerLog($conn, $servername, $username, $password, $dataBase, "temperatura"));
    $hora = array_reverse(lerHora($conn, $servername, $username, $password, $dataBase, "temperatura"));

    foreach (range(0, count(($log))-1) as $x)
    {
        echo "['".$hora[$x]."',". $log[$x]."],";
    }
  ?>
]);
// Set Options
var options = {
  title: 'Temperatura',
  hAxis: {title: 'Data'},
  vAxis: {title: 'Temperatura ºC'},
  legend: 'none'
};
// Draw
var chart = new google.visualization.LineChart(document.getElementById('TempChart'));
chart.draw(data, options);
}
</script>

<script type="text/javascript">
google.charts.load('current',{packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
// Set Data
var data = google.visualization.arrayToDataTable([
  ['sensor', 'valor'],
  <?php
    $log = array_reverse(lerLog($conn, $servername, $username, $password, $dataBase, "luminosidade"));
    $hora = array_reverse(lerHora($conn, $servername, $username, $password, $dataBase, "luminosidade"));

    foreach (range(0, count(($log))-1) as $x)
    {
        echo "['".$hora[$x]."',". $log[$x]."],";
    }
  ?>
]);
// Set Options
var options = {
  title: 'Humidade',
  hAxis: {title: 'Data'},
  vAxis: {title: 'Humidade'},
  legend: 'none'
};
// Draw
var chart = new google.visualization.LineChart(document.getElementById('LumChart'));
chart.draw(data, options);
}

</script>


<script type="text/javascript">
google.charts.load('current',{packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
// Set Data
var data = google.visualization.arrayToDataTable([
  ['sensor', 'valor'],
  <?php
    $log = array_reverse(lerLog($conn, $servername, $username, $password, $dataBase, "humidade"));
    $hora = array_reverse(lerHora($conn, $servername, $username, $password, $dataBase, "humidade"));

    foreach (range(0, count(($log))-1) as $x)
    {
        echo "['".$hora[$x]."',". $log[$x]."],";
    }
  ?>
]);
// Set Options
var options = {
  title: 'Luminosidade',
  hAxis: {title: 'Data'},
  vAxis: {title: 'Temperatura ºC'},
  legend: 'none'
};
// Draw
var chart = new google.visualization.LineChart(document.getElementById('HumidadeChart'));
chart.draw(data, options);
}
</script>


<script type="text/javascript">
google.charts.load('current',{packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
// Set Data
var data = google.visualization.arrayToDataTable([
  ['sensor', 'valor'],
  <?php
    $log = array_reverse(lerLog($conn, $servername, $username, $password, $dataBase, "Deposito_Agua"));
    $hora = array_reverse(lerHora($conn, $servername, $username, $password, $dataBase, "Deposito_Agua"));

    foreach (range(0, count(($log))-1) as $x)
    {
        echo "['".$hora[$x]."',". $log[$x]."],";
    }
  ?>
]);
// Set Options
var options = {
  title: 'Depósito de água',
  hAxis: {title: 'Data'},
  vAxis: {title: 'Litros'},
  legend: 'none'
};
// Draw
var chart = new google.visualization.LineChart(document.getElementById('AguaChart'));
chart.draw(data, options);
}
</script>



<script type="text/javascript">
google.charts.load('current',{packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
// Set Data
var data = google.visualization.arrayToDataTable([
  ['sensor', 'valor'],
  <?php
    $log = array_reverse(lerLog($conn, $servername, $username, $password, $dataBase, "bateria"));
    $hora = array_reverse(lerHora($conn, $servername, $username, $password, $dataBase, "bateria"));

    foreach (range(0, count(($log))-1) as $x)
    {
        echo "['".$hora[$x]."',". $log[$x]."],";
    }
  ?>
]);
// Set Options
var options = {
  title: 'Bateria',
  hAxis: {title: 'data'},
  vAxis: {title: 'Nivel Bateria'},
  legend: 'none'
};
// Draw
var chart = new google.visualization.LineChart(document.getElementById('BatChart'));
chart.draw(data, options);
}



</script>

<!-- Atuadores -->

<script type="text/javascript">
google.charts.load('current',{packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
// Set Data
var data = google.visualization.arrayToDataTable([
  ['sensor', 'valor'],
  <?php
    $log = array_reverse(lerLog($conn, $servername, $username, $password, $dataBase, "iluminação"));
    $hora = array_reverse(lerHora($conn, $servername, $username, $password, $dataBase, "iluminação"));

    foreach (range(0, count(($log))-1) as $x)
    {
        if ($log[$x] == "Ligado")
        {
            echo "['". $hora[$x] . "', 1],";
        }
        else
        {
            echo "['". $hora[$x] . "', 0],";
        }

    }
  ?>
]);
// Set Options
var options = {
  title: 'Iluminação',
  hAxis: {title: 'data'},
  vAxis: {title: 'Estado'},
  legend: 'none'
};
// Draw
var chart = new google.visualization.LineChart(document.getElementById('IlumChart'));
chart.draw(data, options);
}
</script>




<script type="text/javascript">
google.charts.load('current',{packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
// Set Data
var data = google.visualization.arrayToDataTable([
  ['sensor', 'valor'],
  <?php
    $log = array_reverse(lerLog($conn, $servername, $username, $password, $dataBase, "AC"));
    $hora = array_reverse(lerHora($conn, $servername, $username, $password, $dataBase, "AC"));

    foreach (range(0, count(($log))-1) as $x)
    {
        echo "['".$hora[$x]."',". $log[$x]."],";
    }
  ?>
]);
// Set Options
var options = {
  title: 'Ar Condicionado',
  hAxis: {title: 'data'},
  vAxis: {title: 'Temperatura'},
  legend: 'none'
};
// Draw
var chart = new google.visualization.LineChart(document.getElementById('ACChart'));
chart.draw(data, options);
}
</script>





<!-- Atuadores -->

<script type="text/javascript">
google.charts.load('current',{packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
// Set Data
var data = google.visualization.arrayToDataTable([
  ['sensor', 'valor'],
  <?php
    $log = array_reverse(lerLog($conn, $servername, $username, $password, $dataBase, "irrigação"));
    $hora = array_reverse(lerHora($conn, $servername, $username, $password, $dataBase, "irrigação"));

    foreach (range(0, count(($log))-1) as $x)
    {
        if ($log[$x] == "Ligado")
        {
            echo "['". $hora[$x] . "', 1],";
        }
        else
        {
            echo "['". $hora[$x] . "', 0],";
        }

    }
  ?>
]);
// Set Options
var options = {
  title: 'Irrigação',
  hAxis: {title: 'data'},
  vAxis: {title: 'Estado'},
  legend: 'none'
};
// Draw
var chart = new google.visualization.LineChart(document.getElementById('IrrigacaoChart'));
chart.draw(data, options);
}
</script>



<!-- Atuadores -->

<script type="text/javascript">
google.charts.load('current',{packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
// Set Data
var data = google.visualization.arrayToDataTable([
  ['sensor', 'valor'],
  <?php
	$log = array_reverse(explode(PHP_EOL, file_get_contents("api/files/Pulverizador_Fertilizante/log.txt")));//leitura de log, separação em array e inversão do mesmo
	$i = 0;
	$log = array_reverse(array_slice($log, 0, 10));
	foreach ($log as $line)
	{
		if ($i < 11)
		{
			if (strlen($line) > 0)
			{
				$values = explode(";", $line);
				if ($values[1] == "Ligado")
				{
					echo "['".$values[0]."',1],";
				}
				else
				{
					echo "['".$values[0]."',0],";
				}

				$i++;
			}

		}
	}
  ?>
]);
// Set Options
var options = {
  title: 'Pulverizador Fertilizante',
  hAxis: {title: 'data'},
  vAxis: {title: 'Estado'},
  legend: 'none'
};
// Draw
var chart = new google.visualization.LineChart(document.getElementById('FertilChart'));
chart.draw(data, options);
}
</script>

<script type="text/javascript">
google.charts.load('current',{packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
// Set Data
var data = google.visualization.arrayToDataTable([
  ['sensor', 'valor'],
  <?php
    $log = array_reverse(lerLog($conn, $servername, $username, $password, $dataBase, "Seguidor_Solar"));
    $hora = array_reverse(lerHora($conn, $servername, $username, $password, $dataBase, "Seguidor_Solar"));

    foreach (range(0, count(($log))-1) as $x)
    {
        echo "['".$hora[$x]."',". $log[$x]."],";
    }
  ?>
]);
// Set Options
var options = {
  title: 'Posição do motor',
  hAxis: {title: 'data'},
  vAxis: {title: 'º'},
  legend: 'none'
};
// Draw
var chart = new google.visualization.LineChart(document.getElementById('SeguidorSolarChart'));
chart.draw(data, options);
}



</script>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>