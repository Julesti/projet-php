<?php 
require('config.php');
?>

<html>

	<?php include('header.html'); ?>

<body>

	<div class="head"> 
		<p class="title">Afficher les matchs</p>
		<p class="back" ><a href="acceuil.php" style="color:black; ">Retour à l'acceuil</a></p>
	</div>
	
	
	
	
	<table  border=1px style='margin-top:30px; margin-bottom:30px; margin-left:18px; width:97%'>
		<tr>
			<th style='color:#565d5d; font-size:x-large;'>N° Match</th>
			<th style='color:#565d5d; font-size:x-large;'>Date match</th>
			<th style='color:#565d5d; font-size:x-large;'>Heure du match</th>
			<th style='color:#565d5d; font-size:x-large;'>Nom des adversaires </th>
			<th style='color:#565d5d; font-size:x-large;'>Lieu de la rencontre </th>
			<th style='color:#565d5d; font-size:x-large;'> Résultat </th>
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
			<a href="modification_match?id_match=<?php echo $data['id_match']; ?>"> Modifier </a>
		</th>
		<th>
		<form method="GET" action="suppression_match.php">
			<input type="hidden" name="id_match" value="<?php echo $data['id_match']?>" />
			<input type="submit" value="Supprimer" style='font-size: large; height: 40px; float:center; color:#565d5d;  border:none; background-color: white;'/>
		</form>
		</th>
	</tr>
	
	<?php
	}
	
	$req->closeCursor();
	?> 
	</table>
	
	
</body>


</html>
