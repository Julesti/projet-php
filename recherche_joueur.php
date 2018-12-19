<?php require('config.php'); ?>
<html>

	<?php require('header.html'); ?>
	

<body>

	<h1>Gestion des match de volley du club de Toulouse</h1>
	
	<?php 
	
	if(empty($_POST)){
	
	$req = $link->prepare("Select num_licence,nom,prenom from joueur order by joueur.nom");
	
	$req->execute();
	
		
	?>
	
	<p> Liste de joueur : </p>
	
	<form action="recherche_joueur.php" method="post">
	
	<select name="joueur" >
		<?php
		while($data = $req->fetch()){
		echo $data['nom'];
		?>
		<option value='<?php echo $data['num_licence'];?>'><?php echo $data['nom']." ".$data['prenom']; ?> </option>
		<?php
		}
		?>	
	</select>
	
	<br />
	<br />
	<input type="submit" value="valider" />
	</form>
	
	<?php
	}
	else{
		$req = $link->prepare("Select * from joueur 
							WHERE num_licence = :num_licence");
							
		$req->execute(array('num_licence' => $_POST['joueur']));
		
		$data = $req->fetch();
		
		echo "<p>Nom du joueur : ".$data['nom']." ".$data['prenom']."</p>";
		echo "<p>Numero de licence : ".$data['num_licence']."</p>";
		echo "<p>Taille : ".$data['taille']." m</p>";
		echo "<p>Poids : ".$data['poids']." kg</p>";
		echo "<p>Poste occupée : ".$data['poste']." </p>";
		echo "<img src='photos-m3104/".$data['photo']."'> </img>";
		
		?>
		
	<form action="recherche_joueur.php">	
		<input type="submit" value="retour" />
	</form>
	
	<form action="modification_joueur.php" method='get'>	
		<input type="hidden" name="num_licence" value="<?php echo $data['num_licence']?>" />
		<input type="submit" value="modifier" />
	</form>
	
	<form action="suppression_joueur.php" method='get'>	
		<input type="hidden" name="num_licence" value="<?php echo $data['num_licence']?>" />
		<input type="submit" value="supprimer" />
	</form>
	
	
	<?php	
	}
	
	$req->closeCursor();
			
	
	
	?>
	
</body>


</html>
