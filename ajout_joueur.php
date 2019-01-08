<?php 
require('config.php');
require('form.php');
?>

<html>

	<?php include('header.html'); ?>
	

<body>
	
	<div class="head"> 
		<p class="title">Ajouter joueur</p>
		<p class="back" ><a href="acceuil.php" style="color:black; ">Retour à l'acceuil</a></p>
	</div>
	
	<?php
	if(empty($_POST)){
		$form = new form("ajout_joueur.php","post");
	
		$form->setText("Numero de la licence","num_licence","");
		$form->setText("Nom du joueur","nom","");
		$form->setText("Prenom du joueur","prenom","");
		$form->setText("Date de naissance","date","","AAAA-MM-JJ");
		$form->setText("Taille","taille","","ex : 1.80");
		$form->setText("Poids","poids","", "ex : 80");
		
		$form->addText("Poste occupé : ");
		$form->setRadio("poste","Attaquant","attaquant");
		$form->setRadio("poste","Passeur","passeur");
		$form->setRadio("poste","Centre","centre");
		$form->setRadio("poste","Opposé passeur","opposé passeur");
		$form->setRadio("poste","Libero","libero");
		
		$form->setTextarea("Notes personnelle du joueur","note","");
		$form->setInput("Photo du joueur","photo","","file");
		
		$form->addText("Statut du joueur : ");
		$form->setRadio("statut","Actif","actif");
		$form->setRadio("statut","Blessé","blesse");
		$form->setRadio("statut","Suspendu","suspendu");
		$form->setRadio("statut","Absent","absent");
	
		$form->getform();
	}
	
	else{
		print_r($_POST['photo']);
		$req = $link->prepare("INSERT into joueur (num_licence,nom,prenom,photo,date_naissance,taille,poids,poste,notes,statut)
		 Values (:num_licence, :nom, :prenom, :photo, :date, :taille, :poids, :poste, :note, :statut)");
		$req->execute(array('num_licence' => $_POST['num_licence'],
							'nom' => $_POST['nom'],
							'prenom' => $_POST['prenom'],
							'photo' => $_POST['photo'],
							'date' => $_POST['date'],
							'taille' => $_POST['taille'],
							'poids' => $_POST['poids'],
							'poste' => $_POST['poste'],
							'note' => $_POST['note'],
							'statut' => $_POST['statut'])); 
		if($req){
			echo "<p style='font-size: xx-large; mrgin-top:20px; margin-left:25px;'>Joueur ajouté</p>";
		}
		else
			echo "Erreur";
	 
	}
	?>
	
	

</body>


</html>
