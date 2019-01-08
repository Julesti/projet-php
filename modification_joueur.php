<?php require('config.php');
require('form.php');?>


<html>

	<?php require('header.html'); ?>
	

<body>

	<div class="head"> 
		<p class="title">Modifier le joueur</p>
		<p class="back" ><a href="acceuil.php" style="color:black; ">Retour à l'acceuil</a></p>
	</div>
	
	
	<?php
	if(empty($_POST)){
		$req = $link->prepare("Select * from joueur 
							WHERE num_licence = :num_licence");
							
		$req->execute(array('num_licence' => $_GET['num_licence']));
		
		$data = $req->fetch();
		
		$form = new form("modification_joueur.php","post");
		$form->setText("Numero de la licence","num_licence",$data['num_licence']);
		$form->setText("Nom du joueur","nom",$data['nom'],"AAAA-MM-JJ");
		$form->setText("Prenom du joueur","prenom",$data['prenom']);
		$form->setText("Date de naissance","date",$data['date_naissance']);
		$form->setText("Taille","taille",$data['taille']);
		$form->setText("Poids","poids",$data['poids']);
		
		$form->addText("Poste occupé : ");
		$form->setRadio("poste","Attaquant","attaquant");
		$form->setRadio("poste","Passeur","passeur");
		$form->setRadio("poste","Centre","centre");
		$form->setRadio("poste","Oppose passeur","oppose_passeur");
		$form->setRadio("poste","Libero","libero");
		
		$form->setTextarea("Notes personnelle du joueur","note",$data['notes']);
		
		$form->addText("Statut : ");
		$form->setRadio("statut","Actif","actif");
		$form->setRadio("statut","Blessé","blesse");
		$form->setRadio("statut","Suspendu","suspendu");
		$form->setRadio("statut","Absent","absent");
		
		$form->setInput("Photo du joueur","photo","","file");
	
		$form->getform();
	}else{
		$update = $link->prepare("UPDATE joueur 
		SET nom = :nom	,
		prenom = :prenom,
		date_naissance = :date,
		taille = :taille,
		poids = :poids,
		poste = :poste,
		notes = :note,
		statut = :statut,
		photo = :photo 
		WHERE num_licence = :num_licence ");
		
		$update->execute(array( 'num_licence' => $_POST['num_licence'],
								'nom' => $_POST['nom'],
								'prenom' => $_POST['prenom'],
								'date' => $_POST['date'],
								'taille' => $_POST['taille'],
								'poids' => $_POST['poids'],
								'poste' => $_POST['poste'],
								'note' => $_POST['note'],
								'statut' => $_POST['statut'],
								'photo' => $_POST['photo']));
		if($update){
			echo "<p style='font-size: xx-large; mrgin-top:20px; margin-left:25px;'>modifcation effectué</p>";
			?>
			<form action="affichage_joueur.php" >	
				<input style='font-size: x-large; background-color: #A9AFAF; color:black; margin-left:25; margin-top:10px; height: 40px; float:left; width:250px;' type="submit" value="liste des joueurs" />
			</form>
			<?php
		}
	}
		
	
	?>
	
	<script>
	
		var position = '<?php echo $data['poste'];?>';
		var statut = '<?php echo $data['statut'];?>';
		
		window.onload = change_poste(position);
		window.onload = change_statut(statut);
		
		function change_poste(poste){			
			switch(poste){
				case "attaquant":
					document.getElementById('Attaquant').checked = true;
					break;
				case "passeur":  
					document.getElementById('Passeur').checked = true;
					break;
				case "centre": 
					document.getElementById('Centre').checked = true;
					break;
				case "oppose_passeur":
					document.getElementById('Oppose passeur').checked = true;
					break;
				case "libero":
					document.getElementById('Libero').checked = true;
					break;
			}
		}
		
		function change_statut(statut){			
			switch(statut){
				case "actif":
					document.getElementById('Actif').checked = true;
					break;
				case "blesse":  
					document.getElementById('Blessé').checked = true;
					break;
				case "suspendu": 
					document.getElementById('Suspendu').checked = true;
					break;
				case "absent":
					document.getElementById('Absent').checked = true;
					break;

			}
		}
	
	</script>

</body>




</html>
