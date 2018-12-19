<?php
	try{
		$link = new PDO("mysql:host=localhost;dbname=gnd2838a","gnd2838a","nAt2kD4F");
	}catch(Exception $e) {
		die('Erreur : '. $e->getMessage());
	}
	
?>
