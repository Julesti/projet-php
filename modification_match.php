<?php 
require('config.php');
require('form.php');
?>

<html>

	<?php include('header.html'); ?>

<body>
	
	<div class="head"> 
		<p class="title">Modifier le match</p>
		<p class="back" ><a href="acceuil.php" style="color:black; ">Retour à l'acceuil</a></p>
	</div>
	
	<?php 
	
	if(empty($_POST)){
		$req_insert_match = $link->prepare("update matchbis");
	}
	$req_match= $link->prepare("SELECT * from matchbis where id_match = :id_match");
	$req_match->execute(array( 'id_match' => $_GET['id_match']));
	$data = $req_match->fetch();

	?>
	
	<h2>Match du <?php echo $data["date"];?> </h2>
	
	<?php
	if($data['date'] > date("Y-m-d")){
		$form = new form("modification_match.php","post");
		$form->setText("Changez la date du match","date",$data['date']);
		$form->setText("Changez l'heure du match","heure",$data['heure']);
		$form->setText("Changez le nom des adversaire","nom_adversaire",$data['nom_adversaire']);
		$form->addText("Lieu du match");
		$form->setRadio("lieu","Domicile",True);
		$form->setRadio("lieu","Domicile",False);
		$form->setText("Changez le nom des adversaire","nom_adversaire",$data['nom_adversaire']);
		
		$form->getform();
	}else{
		
		$form = new form("modification_match.php","post");
		$form->setText("Notre score","resultat_domicile",$data['resultat_domicile']);
		$form->setText("Score adversaire","date",$data['resultat_adversaire']);
		
		$form->getform();
	}
	?>

	
</body>


</html>
