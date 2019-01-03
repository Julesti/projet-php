<?php 
require('config.php');
require('form.php'); 
?>

<html>

	<?php include('header.html'); ?>

<body>

	<div class="head"> 
		<p class="title">Programmer un match</p>
		<p class="back" ><a href="acceuil.php" style="color:black; ">Retour à l'acceuil</a></p>
	</div>
	
	<?php
	if(empty($_POST)){
		$form = new form("ajout_match.php","post");
	
		$form->setText("Date du match","date","");
		$form->setInput("Heure du match","heure","","time");
		$form->setText("Nom des adversaires","nom_adversaire","");
		$form->addText("Lieu : ");
		$form->setRadio("lieu","Domicile",True);
		$form->setRadio("lieu","Extérieur",False);
		$form->getform();

	}
	
	else{
		$req = $link->prepare("INSERT INTO matchbis (date,heure,nom_adversaire,lieu,resultat_domicile,resultat_adversaire) VALUES (:date, :heure, :nom_adversaire, :lieu, 0, 0)");
		$req->execute(array('date' => $_POST['date'],
							'heure' => $_POST['heure'],
							'nom_adversaire' => $_POST['nom_adversaire'],
							'lieu' => $_POST['lieu'])); 
		if($req){
			echo "Match ajouté";
		}
		else
			echo "Erreur lors de l'ajout du match";
			
			?>
			<br />
			<a href="acceuil.php">Retour à l'acceuil</a>
		<?php
	}
	
	
	?>
	

</body>


</html>
