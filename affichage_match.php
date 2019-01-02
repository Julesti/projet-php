<?php 
require('config.php');
?>

<html>

	<?php include('header.html'); ?>

<body>

	<h1>Gestion des match de volley du club de Toulouse</h1>
	
	<?php include('menu.html'); ?>
	
	<h2>Liste des match : </h2>
	
	
	<table border-collapse=collapse border=1px solid black>
		<tr>
			<th>N° Match</th>
			<th>Date match</th>
			<th>Heure du match</th>
			<th>Nom des adversaires </th>
			<th>Lieu de la rencontre </th>
			<th> Résultat </th>
		</tr>
	<?php
	
	$req = $link->prepare("select * from matchbis");
	$req->execute();
	while($data = $req->fetch()){
	
	?>
	<tr>
		<th> <?php echo $data['id_match']; ?> </th>
		<th> <?php echo $data['date']; ?> </th>
		<th> <?php echo $data['heure']; ?> </th>
		<th> <?php echo $data['nom_adversaire']; ?> </th>
		<th> <?php if($data['lieu'] == 1){echo 'Domicile';}else{echo 'Exterieur';} ?> </th>
		<th> <?php echo $data['resultat_domicile'].'-'.$data['resultat_adversaire']; ?> </th>
		<th>
			<form method="GET" action="suppression_match.php">
				<input type="hidden" name="id_match" value="<?php echo $data['id_match']?>" />
				<input type="submit" value="Supprimer" />
			</form>
		</th>
		<th>
			<form method="GET" action="modification_match.php">
				<input type="hidden" name="id_match" value="<?php echo $data['id_match']?>" />
				<input type="submit" value="Modifier" />
			</form>
		</th>
	</tr>
	
	<?php
	}
	
	$req->closeCursor();
	?> 
	</table>
	
	<a href="acceuil.php">Retour à l'acceuil</a>
	
</body>


</html>
