<?php 
require('config.php');
require('form.php'); 
?>

<html>

	<?php include('header.html'); ?>

<body>

	<div class="head"> 
		<p class="title">Ajouter de notes à un joueur</p>
		<p class="back" ><a href="acceuil.php" style="color:black; ">Retour à l'acceuil</a></p>
	</div>
	
	<?php
	
	//Choisir un joueur
	if(empty($_POST['num_licence'])){
		$req_select_joueur = $link->prepare("Select num_licence,nom,prenom from joueur order by joueur.nom");
		$req_select_joueur->execute();
	
	?>
	
		<p> Liste de joueur : </p>
		
		<form action="ajout_notes_joueur" method="post">
		
		<select name="num_licence" >
			<?php
			while($data = $req_select_joueur->fetch()){
			echo $data['nom'];
			?>
			<option value='<?php echo $data['num_licence'];?>'><?php echo $data['nom']." ".$data['prenom']; ?> </option>
			<?php
			}
			?>	
		</select>
		
		<br />
		<br />
		<input type="submit" value="valider" class="button" />
		</form>
	<?php
	$req_select_joueur->closeCursor();
	}
	//Choisir un match
	if(!(empty($_POST['num_licence'])) && (empty($_POST['id_match']))){
		$req_select_joueur = $link->prepare("Select num_licence,nom,prenom from joueur where num_licence = :num_licence");
		$req_select_joueur->execute(array( 'num_licence' => $_POST['num_licence']))	;
		$joueur = $req_select_joueur->fetch();
		
		$req_match = $link->prepare("Select m.id_match, m.date, m.nom_adversaire
									from jouer_match jm, matchbis m 
									where m.id_match = jm.id_match
									and jm.num_licence = :num_licence");
		$req_match->execute(array( 'num_licence' => $_POST['num_licence']));
		?>
		
		<p> Listes des match jouer par le joueur <?php echo $joueur['nom'].' '.$joueur['prenom'] ; ?> : </p>
		<form action="ajout_notes_joueur" method="post" >
			<select name="id_match" >
				<?php
				while($data = $req_match->fetch()){
				?>
				<option value='<?php echo $data['id_match'];?>'><?php echo $data['date']." ".$data['nom_adversaire']; ?> </option>
				<?php
				}
				?>	
			</select>
			
			<input type="hidden" name="num_licence" value="<?php echo $joueur['num_licence']; ?>" />
			<br />
			<br />
			<input type="submit" value="Valider" class="button" />	
		</form>

		<?php
		$req_select_joueur->closeCursor();
		$req_match->closeCursor();
	}
	//Mettre une note au joueur
	if(!(empty($_POST['num_licence'])) && !(empty($_POST['id_match']))){
		$req_select_joueur = $link->prepare("Select num_licence,nom,prenom from joueur where num_licence = :num_licence");
		$req_select_joueur->execute(array( 'num_licence' => $_POST['num_licence']))	;
		$joueur= $req_select_joueur->fetch();
		
		$req_match = $link->prepare("Select * from matchbis m,jouer_match jm where m.id_match = jm.id_match 
						and m.id_match = :id_match
						and jm.num_licence = :num_licence");
		$req_match->execute(array( 'id_match' => $_POST['id_match'],
									'num_licence' => $_POST['num_licence']));
		$match = $req_match->fetch();
		?>
		
		<p>Veuillez mettre une note pour le joueur <b><?php echo $joueur['nom'].' '. $joueur['prenom']; ?> </b> pour le match du <b><?php echo $match['date'].' contre '. $match['nom_adversaire']; ?></b> :</p>
		<form action="ajout_notes_joueur" method="post">
			<input id="range_note" type="range" name="note" min="0" max="10" step="0.1" onchange="document.getElementById('note').innerHTML = this.value" value="<?php if($match != 0){echo $match['note'];}else {echo 0;}?>" />
			<div class="note">
				<div><p>Note : </p><div>
				<div><p id="note"> </p></div>
			</div>
			
			<input type="hidden" name="num_licence" value="<?php echo $joueur['num_licence']?>" />
			<input type="hidden" name="id_match" value="<?php echo $match['id_match']?>" />
			<input type="submit" class="button" value="Valider" />
		</form>
		<!-- Initialisation de l'affichage du range !-->
		<script>document.getElementById('note').innerHTML = document.getElementById('range_note').value</script>
		<?php
		$req_select_joueur->closeCursor();
		$req_match->closeCursor();
	}
	// Fin note
	
	//Ajout de la note au joueur
	if(!empty($_POST['note'])){
		print_r($_POST);
		$req_update_note = $link->prepare('update jouer_match set note = :note
											where id_match = :id_match
											and num_licence = :num_licence');
											
		$req_update_note->execute(array( 'note' => $_POST['note'],
										'id_match' => $_POST['id_match'],
										'num_licence' => $_POST['num_licence']));
		header("Location:ajout_notes_joueur");
	}
	?>
	
	
	
</body>


</html>


