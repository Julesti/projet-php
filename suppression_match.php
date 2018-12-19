<?php 
require('config.php');
?>

<html>

	<?php include('header.html'); ?>

<body>

	<h1>Gestion des match de volley du club de Toulouse</h1>
	<?php 
	
	if(empty($_POST)){
	?>
		<p>Voulez supprimer le match <?php echo $_GET['id_match'];?> de la liste ?</p>	
		<form action="suppression_match.php" method="post">	
			<input type="hidden" name="id_match" value="<?php echo $_GET['id_match']?>" />
			<input type="submit" value="oui" />
		</form>
	
		<form action="affichage_match.php">	
			<input type="submit" value="non" />
		</form>
	<?php
	
	}else{
	
		$req = $link->prepare("Delete from matchbis where id_match = :id_match");
		$req->execute(array( 'id_match' => $_POST['id_match']));
		header('Location:affichage_match.php');
	
	}
	?>
</body>


</html>
