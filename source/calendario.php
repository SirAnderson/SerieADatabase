<!-- 
     Copyright 2014 Manuel Deleo, Lorenzo Livrini 
     
     This file is part of Serie A Database.

     Serie A Database is free software: you can redistribute it and/or modify
     it under the terms of the GNU General Public License as published by
     the Free Software Foundation, either version 3 of the License, or
     (at your option) any later version.

     Serie A Database is distributed in the hope that it will be useful,
     but WITHOUT ANY WARRANTY; without even the implied warranty of
     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     GNU General Public License for more details.

     You should have received a copy of the GNU General Public License
     along with this program.  If not, see <http://www.gnu.org/licenses/>. 
-->


<?php
session_start();

?>

<html>

<head>
	<title>Serie A Database</title>	
	<LINK REL="SHORTCUT ICON" HREF="favicon.ico">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
	<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
	<meta name="author" content="Manuel Deleo & Lorenzo Livrini" />
	<meta name="description" content="Classifiche, risultati e statistiche Serie A Tim" />
	<meta name="keywords" content="calcio, serie a, tim, campionato" />	
</head>

<body>
	<div id="hmenu">
		<ul>
			<li><a href="index.php">Classifica</a></li>
			<li><a href="calendario.php">Calendario</a></li>
			<li><a href="login.php">Amministrazione</a></li>
		</ul>	
		<?php
		if(!empty($_SESSION['login'])){
			echo "<p><a href='php_logout.php'>Logout</a>";
		}
		$giorn=0;
		if (isset($_POST['giorn'])) {
			if ($_POST['giorn']!="") {
				$giorn=$_POST['giorn'];
			}
		}
		else {
       		$giorn=30;
		}
		?>
	</div>

	<div id="header">	
	</div>

	<div id="content">
		<div id="main">
			<h1>Calendario Serie A</h1>
			
			<form action="" method="post"> 
			<fieldset id="calendfieldset">
				<legend>Scegli giornata</legend>
				
				<!-- Scelgo la giornata della partita -->
				<select id="select1" name="giorn" onchange='this.form.submit()'>
					<?php
					echo "\t<option value=\"\">--GIORNATA--</option>\n";
					for ($i = 1; $i <= 38; $i++) {
						echo "\t<option value=\"$i\"";
						if ($giorn==$i) {
							echo " selected";
						}
						echo ">$i</option>\n";
					}
					?>
				</select>
			</fieldset>
			</form>
			
			<?php
			
			if ($giorn!=0){
			
				echo "<table id=\"caltable\">";
				
				include ('php_functions.php');
				$connection = new createConnection();
				$connection->connectToDatabase();
				$connection->selectDatabase();
				
				// Query per ottenere le partite di una data giornata
				$sql=queryCalendario($giorn);
				
				// Riempo una tabella coi risultati
				while ($partita = mysql_fetch_assoc($sql)){ 
					$squadcasa = $partita['squadcasa'];
					$squadtrasf = $partita['squadtrasf'];
					$golcasa = $partita['gol_casa'];
					$goltrasf = $partita['gol_trasferta'];
					$id_partita = $partita['id_partita'];
					
					//Cliccando sul risultato si viene rimandati al tabellino della partita
					echo "\t<tr><td id=\"calsqtd\"><strong>".$squadcasa."</strong></td>\n";
					echo "\t<td id=\"calristd\"><a href='partite.php?id=$id_partita&casa=$squadcasa&trasf=$squadtrasf'>".$golcasa."</a></td>\n";
					echo "\t<td id=\"calristd\"><a href='partite.php?id=$id_partita&casa=$squadcasa&trasf=$squadtrasf'>-</a></td>\n";
					echo "\t<td id=\"calristd\"><a href='partite.php?id=$id_partita&casa=$squadcasa&trasf=$squadtrasf'>".$goltrasf."</a></td>\n";
					echo "\t<td id=\"calsqtd\"><strong>".$squadtrasf. "</strong></td></tr>\n";
				}
				echo "</table>";
			}
				
				?>
			

				
		</div>
	</div>
	
	<div id="footer">
		<p><a href="http://jigsaw.w3.org/css-validator/check/referer"> Valid <strong>CSS</strong> </a> | Designed and Mastered by <a href="mailto:manuel.deleo@studenti.unipr.it">Manuel Deleo</a> & <a href="mailto:lorenzo.livrini@studenti.unipr.it">Lorenzo Livrini</a></p>
	</div>
	
</body>

</html>
