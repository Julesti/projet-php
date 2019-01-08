<?php 
require('config.php');
require('form.php');
?>

<html>

	<?php include('header.html'); ?>

<body>

	<h1>Gestion des match de volley du club de Toulouse</h1>
	
	<?php 
	include('menu.html'); 
	
	if(isset($_POST['change_info']) and $_POST['change_info'] == True){
		$req_update_match = $link->prepare("update matchbis 
											set date = :date,
											heure = :heure,
											nom_adversaire = :nom_adversaire,
											lieu = :lieu
											where id_match =:id_match");
		$req_update_match->execute(array( 'date' => $_POST['date'],
										  'heure' => $_POST['heure'],
										  'nom_adversaire' => $_POST['nom_adversaire'],
										  'lieu' => $_POST['lieu'],
										  'id_match' => $_POST['id_match']));
		header("Location:affichage_match");									  
	}
	
	if(isset($_POST['change_note']) and $_POST['change_note'] == True){
		
		$req_update_score = $link->prepare("update matchbis 
											set resultat_adversaire = :resultat_adversaire,
											resultat_domicile = :resultat_domicile
											where id_match = :id_match");
		$req_update_score->execute(array( 'resultat_adversaire' => $_POST['resultat_adversaire'],
										  'resultat_domicile' => $_POST['resultat_domicile'],
										  'id_match' => $_POST['id_match']));
		header("Location:affichage_match");	
		
	}
	
	$req_match= $link->prepare("SELECT * from matchbis where id_match = :id_match");
	$req_match->execute(array( 'id_match' => $_GET['id_match']));
	$data = $req_match->fetch();

	?>
	
	<h2>Match du <?php echo $data["date"];?> </h2>
	
	<?php
	//Si la date du match est passé alors on ne peut modifier que le score
	
	
	if($data['date'] > date("Y-m-d")){
		$form = new form("modification_match","post");
		$form->setText("Changez la date du match","date",$data['date']);
		$form->setText("Changez l'heure du match","heure",$data['heure']);
		$form->setText("Changez le nom des adversaire","nom_adversaire",$data['nom_adversaire']);
		$form->addText("Lieu du match");
		$form->setRadio("lieu","Domicile",True);
		$form->setRadio("lieu","Exterieur",0);
		$form->setInput("","id_match",$_GET['id_match'],"hidden");
		$form->setInput("","change_info",True,"hidden");
		
		$form->getform();
	}//Modification score
	else{
		
		$form = new form("modification_match","post");
		$form->setText("Notre score","resultat_domicile",$data['resultat_domicile']);
		$form->setText("Score adversaire","resultat_adversaire",$data['resultat_adversaire']);
		$form->setInput("","change_note",True,"hidden");
		$form->setInput("","id_match",$_GET['id_match'],"hidden");
		
		$form->getform();
		
	}
	?>
	<br />
	<br />
	<a href="affichage_match"> Retourner à la liste des matchs </a>
	
	<script>
	
		var lieu = '<?php echo $data['lieu'];?>';
		
		window.onload = change_location(lieu);
		
		function change_location(lieu){
			if(lieu == 1){				
				document.getElementById('Domicile').checked = true;
			}
			else{
				document.getElementById('Exterieur').checked = true;
			}
		}
		
	
	
	
	</script>
	
</body>


</html>
