<?php 
require('config.php');
require('form.php'); 
?>

<html>

	<?php include('header.html'); ?>

<body>

	<script src="https://code.jquery.com/jquery-3.0.0.js"></script>
	<script src="https://code.jquery.com/jquery-migrate-3.0.1.js"></script>
	<h1>Gestion des match de volley du club de Toulouse</h1>
	
	
	<?php
		$var = 0;
		if(isset($_POST['id_match'])){
			$var = $_POST['id_match'];
		}
		
		if(!(isset($_POST['num_licence']))){
	?>
	
		
		
			<form name="form_match" action="feuille_match.php" method="post">
				<p> Liste match à préparer : </p>
		
				<!-- Liste des match à préparer!-->
				<select id="match" name="id_match" onchange='document.forms.form_match.submit();'>
					<option value="">--- Choissiser un match ---</option>
					<?php 			
					$req_match = $link->prepare("Select * 
					from matchbis 
					where CAST(NOW() AS DATE) < date");
					$req_match->execute();
			
					while($data = $req_match->fetch()){	
					?>
						 <option value="<?php echo $data['id_match'];?>"> <?php echo $data['date'].' '.$data['nom_adversaire'];?> </option>
					<?php
					}
					?>
				</select>
			</form>
			<br />
			<br />
			
			
			<form name="form_joueur" action="feuille_match.php" method="post">
			<!--Liste des joueurs actifs !-->
			<p> Veuillez choisir la position du joueur à ajouter dans la liste : </p>
		
			
					<input type="radio" name="position" value="titulaire" id="titu" checked>Titulaire</input>
					<input type="radio" name="position" value="remplacant" id="rem">Remplaçant</input>
					
					<br />
					<br />
					
					
					<select id="joueur"  name="num_licence">
						<?php
					
						$req_joueur = $link->prepare('Select num_licence, nom, prenom, poste from joueur 
						where statut like "actif"');
						$req_joueur->execute();
					
						while($data = $req_joueur->fetch()){
							?>
							<option value="<?php echo $data['num_licence']; ?>">
							<?php echo $data['nom'].' '.$data['prenom'].' - '.$data['poste'];	?>
							</option>
							<?php
						}
						?>
						<br />
					</select>
					
					<?php
					if(isset($_POST['id_match'])){
						?>
						<input type="hidden" name="id_match" value="<?php echo $_POST['id_match']; ?>" />
						<?php
					} 
					?>
					<input type="submit" value="Ajouter le joueur"/>	
			</form>
			<br />
		
			
			<p>Liste joueur Titulaire :</p>
			<select id="liste_joueur_titulaire" name="joueur_tit" size="6">
			<?php 
			
			
			if(isset($_POST['id_match'])){
				$req_joueur_tit = $link->prepare('select j.num_licence,j.nom,j.prenom 
					from joueur j, jouer_match jo 
					where j.num_licence = jo.num_licence 
					and jo.position like "titulaire" and jo.id_match='.$_POST["id_match"]);
					$req_joueur_tit->execute();
					

				while($data = $req_joueur_tit->fetch()){
					?>
					<option value="<?php echo $data["num_licence"];?>"> <?php echo $data['nom'].' '.$data['prenom'];?> </option>			
					<?php
				}
				$req_joueur_tit->closeCursor();
			}
			?>
			
			</select>
		
			<br />
			<br />
		
			<p>Liste joueurs remplaçant : </p>
			<select id="liste_joueur_remplacant" name="joueur_rem"size="3">
		
				<?php 
				if(isset($_POST['id_match'])){
					$req_joueur_rem = $link->prepare('select j.num_licence,j.nom,j.prenom 
					from joueur j, jouer_match jo
					where j.num_licence = jo.num_licence 
					and jo.position like "remplacant"
					and jo.id_match='.$_POST["id_match"]);
					$req_joueur_rem->execute();
			
				while($data = $req_joueur_rem->fetch()){
					?>
					<option value="<?php echo $data["num_licence"];?>"> <?php echo $data['nom'].' '.$data['prenom'];?> </option>			
					<?php
				}
				$req_joueur_rem->closeCursor();
			}
			?>
		
			</select>
		
			<br />
			<br />
			<input type="submit" value="Créer fiche de match" />
	
	
		<?php
		$req_joueur->closeCursor();
		$req_match->closeCursor(); 
		
		
	// Insertion dans la base de données	
	}else{
		$req_insert = $link->prepare('insert into jouer_match(id_match,num_licence,position,note) values (:id_match, :num_licence, :position,0)');
		$req_insert->execute(array('id_match' => $_POST['id_match'],
									'num_licence' => $_POST['num_licence'],
									'position' => $_POST['position']));	
		
	  	header('Location:feuille_match.php');
		}
	?>
	
	
	<script>
		
		var match = <?php echo json_encode($var);?>;
		/**
		$.(document).ready(function(){
			$('#match option[value="' + match + '"]').prop('selected', true);
		});
		
		function changeSelected(value){
			document.getElementById('match').getElementsByTagName('option')[value].selected = 'selected';
		}
		*/
	
	</script>
	
</body>


</html>


