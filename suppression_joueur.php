<?php require('config.php'); ?>
<html>

	<?php include('header.html'); ?>
	

<body>

	<div class="head"> 
		<p class="title">Supprimer un joueur</p>
		<p class="back" ><a href="acceuil.php" style="color:black; ">Retour à l'acceuil</a></p>
	</div>
	
	
	<?php 
	
	if(empty($_POST)){
	?>
		<p style="font-size: x-large; mrgin-top:20px; margin-left:25px;">Voulez vous supprimer ce joueur ? </p>
	
		<form action="suppression_joueur.php" method="post">	
			<input type="hidden" name="num_licence" value="<?php echo $_GET['num_licence']?>" />
			<input style='font-size: x-large; background-color: #A9AFAF; color:black; margin-left:25; margin-top:10px; height: 40px; float:left; width:250px;'  type="submit" value="oui" />
		</form>
	
		<form action="affichage_joueur.php">	
			<input style='font-size: x-large; background-color: #A9AFAF; color:black; margin-left:25; margin-top:10px; height: 40px; float:left; width:250px;' type="submit" value="non" />
		</form>
	<?php
	
	}else{
		$req = $link->prepare("DELETE FROM joueur WHERE num_licence = :num_licence");
		$req->execute(array('num_licence' => $_POST['num_licence']));
		header('Location:affichage_joueur.php');
	}
	?>
	

</body>


</html>

