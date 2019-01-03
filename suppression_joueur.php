<?php require('config.php'); ?>
<html>

	<?php require('header.html'); ?>
	

<body>

	<div class="head"> 
		<p class="title">Supprimer un joueur</p>
		<p class="back" ><a href="acceuil.php" style="color:black; ">Retour à l'acceuil</a></p>
	</div>
	
	
	<?php 
	
	if(empty($_POST)){
	?>
		<p>Voulez vous supprimer ce joueur ? </p>
	
		<form action="suppression_joueur.php" method="post">	
			<input type="hidden" name="num_licence" value="<?php echo $_GET['num_licence']?>" />
			<input type="submit" value="oui" />
		</form>
	
		<form action="recherche_joueur.php">	
			<input type="submit" value="non" />
		</form>
	<?php
	
	}else{
		$req = $link->prepare("DELETE FROM joueur WHERE num_licence = :num_licence");
		$req->execute(array('num_licence' => $_POST['num_licence']));
		header('Location:recherche_joueur.php');
	}
	?>
	

</body>


</html>
