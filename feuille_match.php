<?php 
require('config.php');
require('form.php'); 
?>

<html>

	<?php include('header.html'); ?>

<body>

	<div class="head"> 
		<p class="title">Préparer un match</p>
		<p class="back" ><a href="acceuil.php" style="color:black; ">Retour à l'acceuil</a></p>
	</div>
	
	
	
	<?php
		$var = 0;
		if(isset($_POST['id_match'])){
			$var = $_POST['id_match'];
		}
		
		//Requete suppression de match
		if(isset($_POST['supprimer']) && $_POST['supprimer'] == True){
			$req_suppr = $link->prepare('DELETE from jouer_match where id_match = :id_match and num_licence = :num_licence');
			$req_suppr->execute(array( 'id_match' => $_POST['id_match'],
										'num_licence' => $_POST['num_licence']));
					
			
		}
		
		//Requete d'insertion du match
		if(isset($_POST['num_licence']) && !isset($_POST['supprimer'])){
			$req_insert = $link->prepare('insert into jouer_match(id_match,num_licence,position,note) values (:id_match, :num_licence, :position,0)');
			$req_insert->execute(array('id_match' => $_POST['id_match'],
									'num_licence' => $_POST['num_licence'],
									'position' => $_POST['position']));
			
		}
	?>
	
		
			<form name="form_match" action="feuille_match.php" method="post">
				<p style='font-size: x-large; margin-left : 30px; float:left;'> Liste match à préparer : </p>
		
				<!-- Liste des match à préparer!-->
				<p style='float:left; margin-top:27px;'><select  style='font-size: large; width:500px; margin-left : 50px;' id="match" name="id_match" onchange='document.forms.form_match.submit();'>
					<option value="">Choissiser un match</option>
					<?php 			
					$req_match = $link->prepare("Select * 
					from matchbis 
					where CAST(NOW() AS DATE) < date");
					$req_match->execute();
			
					while($data = $req_match->fetch()){	
					?>
						 <option value="<?php echo $data['id_match'];?>" <?php if($data['id_match'] == $var){echo 'selected';}?>> <?php echo $data['date'].' '.$data['nom_adversaire'];?> </option>
					<?php
					}
					?>
				</select></p></br>
			</form>
			<br />
			<br />
			
			
			<form name="form_joueur" action="feuille_match.php" method="post">
			<!--Choix de la position des joueurs!-->
			<p style='font-size: x-large; margin-left : 30px; '> Veuillez choisir la position du joueur à ajouter dans la liste : </p>
					<p style='font-size: x-large; margin-left : 60px; '>
					<input type="radio" name="position" value="titulaire" id="titu" checked>Titulaire</input>
					<input type="radio" name="position" value="remplacant" id="rem">Remplaçant</input>
					</p>
					<br />
					<br />
					
					<!-- Listes de joueurs à ajouter -->
					<select style='font-size: large; margin-left : 30px; ' id="joueur"  name="num_licence">
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
					<input style='font-size: large; background-color: #A9AFAF; color:black; height: 27px; width:200px; margin-left:15px;' type="submit" value="Ajouter le joueur"/>	
			</form>
			<br />
		
			<!-- Listes joueurs Titulaires -->
			<p style='font-size: x-large; margin-left : 30px; '>Liste joueur Titulaire :</p>
			<select style='font-size: large; margin-left : 30px; ' id="liste_joueur_titulaire" name="joueur_tit" size="6">
			<?php 
			
			
			if(isset($_POST['id_match'])){
				$req_joueur_tit = $link->prepare('select j.num_licence,j.nom,j.prenom 
					from joueur j, jouer_match jo 
					where j.num_licence = jo.num_licence 
					and jo.position like "titulaire" and jo.id_match='.$_POST["id_match"]);
					$req_joueur_tit->execute();
					

				while($data = $req_joueur_tit->fetch()){
					?>
					<option value="<?php echo $data["num_licence"];?>" onclick="affiche_bouton(this)"> <?php echo $data['nom'].' '.$data['prenom'];?> </option>			
					<?php
				}
				$req_joueur_tit->closeCursor();
			}
			?>
			
			</select>
			

			<br />
			<br />
		
			<p style='font-size: x-large; margin-left : 30px; '>Liste joueurs remplaçant : </p>
			<select  style='font-size: large; margin-left : 30px;'id="liste_joueur_remplacant" name="joueur_rem"size="3">
		
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
					<option value="<?php echo $data["num_licence"];?>" onclick="affiche_bouton(this)"> <?php echo $data['nom'].' '.$data['prenom'];?> </option>			
					<?php
				}
				$req_joueur_rem->closeCursor();
			}
			?>
		
			</select>
		
			<br />
			<br />
			<?php
			// Suppression d'un joueur
			if(isset($_POST['id_match'])){
				?>
			<form action="feuille_match" method="post">
				<input type="hidden" name="id_match" value="<?php echo $_POST['id_match']; ?>" />
				<input type="hidden" name="supprimer" value=True />
				<input type="hidden" id="hidden_joueur" name="num_licence" value=""/>
				<input type="submit" id="hidden_but" value="Supprimer" class="button_hidden" />
			</form>
			<?php
			}
			?>
	
	
		<?php
		$req_joueur->closeCursor();
		$req_match->closeCursor(); 
		
		
	// Insertion dans la base de données	

	?>
	
	<script>
	
		function affiche_bouton(elm){
			document.getElementById("hidden_but").style.visibility = "visible";
			document.getElementById("hidden_joueur").value = elm.value;
		}
	
	</script>
	
</body>


</html>


