<?php 
require('config.php');
require('form.php');
?>

<html>

	<?php include('header.html'); ?>

<body>
	
	<?php 
	include('menu.html'); 
	//Nombre total de match jouée
	$req_total_match = $link->prepare("Select COUNT(*) total from matchbis where date < NOW()");
	$req_total_match->execute();
	$total_match = $req_total_match->fetch()['total'];
	
	//Nombre de match gagne
	$req_total_match_gagne = $link->prepare("Select COUNT(*) total from matchbis where resultat_domicile > resultat_adversaire");
	$req_total_match_gagne->execute();
	$total_gagne = $req_total_match_gagne->fetch()['total'];
	
	//Total match perdu
	$req_total_match_perdu = $link->prepare("Select COUNT(*) total from matchbis where resultat_domicile < resultat_adversaire");
	$req_total_match_perdu->execute();
	$total_perdu = $req_total_match_perdu->fetch()['total'];
	
	//Total de match nul
	$total_nul = $total_match - $total_gagne - $total_perdu;
	
	$req_total_match->closeCursor();
	$req_total_match_gagne->closeCursor();
	$req_total_match_perdu->closeCursor();
	
	$req_joueur = $link->prepare("Select * from joueur order by nom");
	$req_joueur->execute();
	?>
	
	<div>
		<p> Nombre total de match joué : <?php echo $total_match ?> <p/>
		<p> Nombre de match gagné : <?php echo $total_gagne; ?></p>
		<p>Nombre de match perdu : <?php echo $total_perdu;?></p>
	
		<p> Pourcentage de match gagné : <?php echo ($total_gagne/$total_match)*100;?>% </p> 
		<p> Pourcentage de match perdu : <?php echo ($total_perdu/$total_match)*100;?>% </p> 
	</div>
	
	<div>
		<table class="tab">
			<tr>
				<th>Nom du joueur</th>
				<th>Statut</th>
				<th>Poste préféré</th>
				<th>Nombres total de selections en tant que titulaires</th>
				<th>Nombres total de selections en tant que remplaçants</th>
				<th>Moyennes évalutations</th>
				<th>Pourcentages de match gagné avec le joueur</th>
			</tr>
			<?php
			while($joueur = $req_joueur->fetch()){
				//Nombre de fois que le joueur est titulaire
				$req_nb_select = $link->prepare	("Select COUNT(*) total from jouer_match where num_licence = :num_licence and position = 'titulaire'");
				$req_nb_select->execute(array( 'num_licence' => $joueur['num_licence']));
				$nb_titu = $req_nb_select->fetch()['total'];
				
				//Nombres de fois remplaçant
				$req_nb_remp = $link->prepare("Select COUNT(*) total from jouer_match where num_licence = :num_licence and position = 'remplacant'");
				$req_nb_remp->execute(array( 'num_licence' => $joueur['num_licence']));
				$nb_remp = $req_nb_remp->fetch()['total'];
				
				$req_moyenne = $link->prepare("Select AVG(note) moyenne from jouer_match where num_licence = :num_licence");
				$req_moyenne->execute(array( 'num_licence' => $joueur['num_licence']));
				$moyenne = $req_moyenne->fetch()['moyenne'];
				
				$req_gagne = $link->prepare("Select COUNT(*) total from jouer_match jm, matchbis m 
				where jm.num_licence = :num_licence 
				and jm.id_match = m.id_match
				and m.resultat_domicile > m.resultat_adversaire");
				$req_gagne->execute(array( 'num_licence' => $joueur['num_licence']));
				$nb_match_gagne = $req_gagne->fetch()['total'];
				?>
				<tr>
					<th><?php echo $joueur['nom'] .' '. $joueur['prenom'] ;?> </th>
					<th><?php echo $joueur['statut'] ?></th>
					<th><?php echo $joueur['poste'] ?></th>
					<th><?php echo $nb_titu ?></th>
					<th><?php echo $nb_remp ?></th>
					<th><?php echo $moyenne ?></th>
					<th> <?php echo ($nb_match_gagne/$total_match)*100; ?>%</th>
				</tr>
				<?php
			}
			?>
		</table>
	
	</div>
	
</body>


</html>
