<?php 
require('config.php');
?>

<html>

	<?php include('header.html'); ?>

<body>

	<div class="head"> 
		<p class="title">Liste de joueur</p>
		<p class="back" ><a href="acceuil.php" style="color:black; ">Retour à l'acceuil</a></p>
	</div>
	
	
	
	
	<table  border=1px style='margin-top:30px; margin-bottom:30px; margin-left:18px; width:97%'>
		<tr>
			<th style='color:#565d5d; font-size:x-large;'>N° licence</th>
			<th style='color:#565d5d; font-size:x-large;'>Nom</th>
			<th style='color:#565d5d; font-size:x-large;'>Prenom</th>
			<th style='color:#565d5d; font-size:x-large;'>Date de naissance</th>
			<th style='color:#565d5d; font-size:x-large;'>Taille</th>
			<th style='color:#565d5d; font-size:x-large;'>Poids </th>
			<th style='color:#565d5d; font-size:x-large;'>Notes</th>
			<th style='color:#565d5d; font-size:x-large;'>Statut</th>
			<th style='color:#565d5d; font-size:x-large;'> Poste occupée </th>
			<th style='color:#565d5d; font-size:x-large;'>Photo</th>
		</tr>
	<?php
	
	$req = $link->prepare("select * from joueur");
	$req->execute();
	while($data = $req->fetch()){
	
	?>
	<tr>
		<th> <?php echo $data['num_licence']; ?> </th>
		<th> <?php echo $data['nom']; ?> </th>
		<th> <?php echo $data['prenom']; ?> </th>
		<th> <?php echo $data['date_naissance']; ?> </th>
		<th> <?php echo $data['taille']; ?> </th>
		<th> <?php echo $data['poids'] ?> </th>
		<th> <?php echo $data['notes']; ?> </th>
		<th> <?php echo $data['statut']; ?> </th>
		<th> <?php echo $data['poste'] ?> </th>
		<th> <img src="<?php echo $data['photo'] ?> "> </th>
		<th>
			<form action="modification_joueur.php" method='get'>	
				<input type="hidden" name="num_licence" value="<?php echo $data['num_licence']?>" />
				<input type="submit" value="modifier" style='font-size: large; height: 40px; float:center; color:#565d5d;  border:none; background-color: white;'/>
			</form>
		</th>
		<th>
			<form method="GET" action="suppression_joueur.php">
				<input type="hidden" name="num_licence" value="<?php echo $data['num_licence']?>" />
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
