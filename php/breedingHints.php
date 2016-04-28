<?php

require_once 'autoload.php';
require_once 'common.php';

$dragonvaleDB = DragonvaleDB::getInstance();

?>

<!DOCTYPE html>

<html>

<head>
	<title>Breeding Hints - DragonSearch - A Dragonvale database</title>

	<meta charset="UTF-8" />
	<meta http-equiv="content-type" content="text/html" />
	<meta lang="it" name="application-name" content="Ottenere i draghi su Dragonvale" />
	<meta name="author" content="Davide Laezza" />
	<meta lang="it" name="desctiption" content="Ottenere informazioni su come si ottengono i vari draghi di Dragonvale" />

	<script charset="UTF-8" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
	<script charset="UTF-8" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-sanitize.min.js"></script>
	<script charset="UTF-8" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-select/0.16.1/select.min.js"></script>
	<script charset="UTF-8" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-md5/0.1.10/angular-md5.min.js"></script>
	<script charset="UTF-8" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
	<script charset="UTF-8" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-moment/1.0.0-beta.6/angular-moment.min.js"></script>
	<script charset="UTF-8" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sprintf/1.0.3/sprintf.min.js"></script>
	<script charset="UTF-8" type="text/javascript" src="https://raw.githubusercontent.com/L42y/angular-sprintf/master/angular-sprintf.js"></script>
	<script charset="UTF-8" type="text/javascript" src="../js/dragonSearch.module.js"></script>
	<script charset="UTF-8" type="text/javascript" src="../js/dragonSearch.config.js"></script>
	<script charset="UTF-8" type="text/javascript" src="../js/dragonSearch.breeding.hints.controller.js"></script>
	<script charset="UTF-8" type="text/javascript" src="../js/dragonSearch.time.tweak.box.js"></script>
	<script charset="UTF-8" type="text/javascript" src="../js/dragonSearch.image.js"></script>
	<script charset="UTF-8" type="text/javascript" src="../js/dragonSearch.time.tweak.js"></script>
	<script charset="UTF-8" type="text/javascript" src="../js/dragonSearch.dragon.box.js"></script>
	<script charset="UTF-8" type="text/javascript" src="../js/dragonSearch.elem.box.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.4.5/select2.min.css" />
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-select/0.16.1/select.min.css" />
	<link rel="stylesheet" type="text/css" href="../css/breedingHints.css" />
</head>

<body>
	<header>
		<h1>Breeding Hints</h1>
	</header>
	<main data-ng-app="dragonSearch" data-ng-controller="BreedingHintsController as model">
		<section class="input">
			<label for="name">Nome:</label>
			<ui-select id="name" class="ui-select" data-ng-model="model.dragon"\
					data-ng-change="model.requestHint()">
				<ui-select-match data-placeholder="Seleziona un drago">{{ $select.selected.name }}</ui-select-match>
				<ui-select-choices data-repeat="item in (model.names | filter :
						{name: $select.search} : model.startsWith)">
					{{ item.name }}
				</ui-select-choices>
			</ui-select>
			<time-tweak-box data-on-redu-change="model.toggleRed(red)"
					data-on-dd-change="model.toggleDd(dd)"
					data-dragons="model.dragons"></time-tweak-box>
		</section>
		<section class="breeding-hints">
			<!-- Page load -->
			<span data-ng-if="model.hints.length == 0">Nessun drago selezionato</span>

			<div data-ng-repeat="hint in model.hints | limitTo : 10">
				<dragon-box data-dragon="hint"></dragon-box>
				<span>=</span>

				<!-- Parent1 -->
				<dragon-box data-ng-if="hint.parent1" data-dragon="hint.parent1"
						data-on-click="model.requestHint(id)"></dragon-box>
				<span data-ng-if="hint.parent1">+</span>

				<!-- Parent2 -->
				<dragon-box data-ng-if="hint.parent2" data-dragon="hint.parent2"
						data-on-click="model.requestHint(id)"></dragon-box>

				<!-- Elem breed -->
				<elem-box data-ng-repeat-start="elem in hint.breedElems"
						  data-name="elem"></elem-box>
				<span data-ng-if="!$last || hint.notes" data-ng-repeat-end>+</span>

				<!-- Basic breeding rule -->
				<elem-box data-ng-if="model.isBasicBreedingRule(hint)" data-name="elem"
						  data-ng-repeat-start="elem in hint.elems"></elem-box>
				<span data-ng-if="model.isBasicBreedingRule(hint) && !$last" data-ng-repeat-end>+</span>

				<!-- Notes -->
				<span data-ng-if="hint.notes" class="note">{{ hint.notes }}</span>

			</div>
		</section>
	</main>
	<?php require 'dragonvaleFooter.php'; ?>
</body>

</html>
