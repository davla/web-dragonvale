<?php

require_once 'autoload.php';
require_once 'common.php';

$dragonvaleDB = DragonvaleDB::getInstance();
$elems = makeOptions(array_column($dragonvaleDB -> allElements(), 1, 0), true);

// array_columns changes returned indexes into html attributes
$parents = makeOptions(array_columns($dragonvaleDB -> allParents(),
		['id', 'name', 'opposite'], ['value', 'text', 'data-opposite-id']));

?>

<!DOCTYPE html>

<html>

<head>
	<title>DragonSearch - A Dragonvale database</title>

	<meta charset="UTF-8" />
	<meta http-equiv="content-type" content="text/html" />
	<meta lang="it" name="application-name" content="Ricreca di draghi per Dragonvale" />
	<meta name="author" content="Davide Laezza" />
	<meta lang="it" name="desctiption" content="Ricercare i draghi di dragonvale per tempo d'incubazione, nome, elementi e/o coppia di genitori" />

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css" />
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tooltipster/3.3.0/css/tooltipster.min.css" />
	<link rel="stylesheet" type="text/css" href="./css/index.css" />

	<script charset="UTF-8" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script charset="UTF-8" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
	<script charset="UTF-8" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sprintf/1.0.3/sprintf.min.js"></script>
	<script charset="UTF-8" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
	<script charset="UTF-8" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tooltipster/3.3.0/js/jquery.tooltipster.min.js"></script>
	<script charset="UTF-8" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/md5.js"></script>
	<script charset="UTF-8" type="text/javascript" src="../util/js/jquery-util.js"></script>
	<script charset="UTF-8" type="text/javascript" src="../util/js/Pagination.js"></script>
	<script charset="UTF-8" type="text/javascript" src="../util/js/jquery-ajaxTable.js"></script>
	<script charset="UTF-8" type="text/javascript" src="../util/js/pagination-default.js"></script>
	<script charset="UTF-8" type="text/javascript" src="./js/ajaxUpdate.js"></script>
	<script charset="UTF-8" type="text/javascript" src="./js/index.js"></script>
</head>

<body>
	<?php require 'navBar.html'; ?>
	<header>
		<h1>DragonSearch</h1>
	</header>
	<main>
		<form action="#" method="GET" name="form">
			<div>
				<div>
					<label>Nome:
						<select name="id">
							<option value="0">Non specificato</option>
						<?php
							echo makeOptions(array_column($dragonvaleDB -> allNames(), 'name', 'id'), true);
						?>
						</select>
					</label>
					<label>Tempo di incubazione:
						<select name="time"><!-- Filled by AJAX -->
							<option value="0">Non specificato</option>
						</select>
					</label>
					<label>Elemento 1:
						<select name="elem1">
							<option value="0">Non specificato</option>
							<?php echo $elems; ?>
						</select>
					</label>
					<label>Elemento 2:
						<select name="elem2">
							<option value="0">Non specificato</option>
							<?php echo $elems; ?>
						</select>
					</label>
				</div>
				<div>
					<label>Elemento 3:
						<select name="elem3">
							<option value="0">Non specificato</option>
							<?php echo $elems; ?>
						</select>
					</label>
					<label>Elemento 4:
						<select name="elem4">
							<option value="0">Non specificato</option>
							<?php echo $elems; ?>
						</select>
					</label>
					<label>Genitore:
						<select name="parent1">
							<option value="0">Non specificato</option>
							<?php echo $parents; ?>
						</select>
					</label>
					<label>Genitore:
						<select name="parent2">
							<option value="0">Non specificato</option>
							<?php echo $parents; ?>
						</select>
					</label>
				</div>
			</div>
			<div>
				<input id="reduced" type="checkbox" name="reduced" value="1">
				<label for="reduced">Tempi di incubazione ridotti</label>
				<input id="display-days" type="checkbox" name="displayDays" value="1">
				<label for="display-days">Visualizza i giorni nei tempi di incubazione</label>
				<input id="strict-order" type="checkbox" name="strictOrder" value="1">
				<label for="strict-order">Considera l'ordine degli elementi</label>
			</div>
			<button formnovalidate type="submit" name="submit">Cerca</button>
		</form>
		<?php require 'pagination-default.html'; ?>
		<table>
			<thead>
				<tr>
					<th>Drago</th>
					<th>Tempo d'incubazione</th>
					<th>Elemento</th>
					<th>Elemento</th>
					<th>Elemento</th>
					<th>Elemento</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="6">Nessun drago selezionato</td>
				</tr>
			</tbody>
		</table>
	</main>
	<?php require 'dragonvaleFooter.php'; ?>
</body>

</html>
