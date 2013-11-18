<?php 

session_start();
header('Content-type: text/html; charset=utf-8');
include('includes/config.php'); 
include('includes/fonctions.php'); 

$titre = "Paris Slackline - Login";
$custom_class = "logged";

include('header.php');

// Si l'utilisateur est identifié 
if ( isset($_SESSION['membre_logged_in']) && !empty($_SESSION['membre_logged_in']) && $_SESSION['membre_logged_in'] === true ){

	//var_dump($_SESSION);
	// echo " <br/> BDD Email  : ".$_SESSION['membre_email'];
	// echo " <br/> BDD Identifiant  : ".$_SESSION['membre_id'];
	// echo " <br/> BDD Mdp  : ".$_SESSION['membre_mdp']." <br/><br/>";

	?>


	<button class="temp"> SPOTS OUVERT </button>

	<!--<button id="getProfil"> Mon profil </button>-->

	<div class="content">

	</div>

	<?php //nextDays(5); ?>

	<div id="content">

	</div>
	<div id="slackers">
	
	</div>
	
	
	<!-- CODE SYLVAIN FUSION -->
	
		<button id="maPosition">Me localiser</button>
        <div id="answer">
        </div>
        <div id="map">
        </div>

        <div id="dialog-form" title="Ajouter un spot">
            <p class="validateTips">All form fields are required.</p>

            <form>
                <fieldset>
                    <label for="titre">Nom du spot : </label>
                    <input type="text" name="titre" class="text ui-widget-content ui-corner-all" id="name" />
                    <label for="description">Description du spot : </label>
                    <input type="text" name="description" class="text ui-widget-content ui-corner-all" />
                    <label for="adresse">Adresse du spot :</label>
                    <input type="text" name="adresse" class="text ui-widget-content ui-corner-all">
                    <!-- <input type="checkbox" name="categorie" value="shortline"><label>shortline</label>
                    <input type="checkbox" name="categorie" value="longline"><label>longline</label> -->
                </fieldset>
            </form>
        </div>
	
	<!-- FIN CODE SYLVAIN FUSION -->

	<!-- FUSION CODE AUDREY -->

	<!-- STEP 1 -->

	<aside id="accueilCarte">

		<section class="logo">
			<img src="img/logo2.svg" alt="Logo" />
		</section>

		<section class="rechercheSpot">
			<h2><strong>Rechercher</strong> un spot</h2>
			<input type="text" class="searchSpot" id="searchSpot" placeholder="Vincennes, Ourcq…" />
			<label for="searchSpot" class='btn-search'/>Rechercher</label>
			<div id="resultSpots"></div>
		</section>

		<section class="marquerSpot">
			<h2><strong>Marquer</strong> un spot</h2>
			<button id="spotStep2" class="btn large">Marquer un spot</button>
			<!-- <a href="placerMarqueur.php"></a> -->
		</section>

		<section class="RechercheSlacker">
			<h2><strong>Rechercher</strong> un slacker</h2>
			<input type="text" class="searchUser" id="searchUser" placeholder="Tapez un nom" />
			<label for='searchUser' class='btn-search'>Rechercher</label>
			<div id="resultUsers"></div>
		</section>

	</aside>

	<!-- STEP 2 -->

	<aside id="placerMarqueur" class="hidden">
	
		<nav>
			<ul>
				<li><a href="accueilCarte.php"><img src="img/precedent.svg" alt="Page précédente" /></a></li>
				<li><a href="#"><img src="img/close.svg" alt="fermer" /></a></li>
			</ul>
		</nav>

		<section class="logo">
			<img src="img/logo2.svg" alt="Logo" />
		</section>

		<section class="placerLieu">
			<h2><strong>Placez</strong> votre lieu</h2>
			<p>Sur la carte à l’aide du clic droit ou entrez une adresse</p>
			<input type="text" class="searchSpot" id="searchSpot" placeholder="Vincennes, Ourcq…" />
			<label for="searchSpot" class='btn-search'/>Rechercher</label>
			<div id="resultSpots"></div>
		</section>

		<section class="quand">
			<h2><strong>Quand</strong> irez-vous à<br />ce spot ?</h2>
			
			<div class="selectJour">
			<select>
              <option value="aujourd">Aujourd'hui</option>
              <option value="demain">Demain</option>
              <option value="demain">Dans une semaine</option> 
            </select> 
			</div>
			
			<div class="selectHeureDepart">
				<select>
					<option value="9">9h00</option>
					<option value="915">9h15</option>
					<option value="930">9h30</option>
					<option value="945">9h45</option>
					<option value="10">10h00</option> 
				</select> 
			</div>
			<div class="selectHeureArrivee">
				<select>
					<option value="9">9h00</option>
					<option value="915">9h15</option>
					<option value="930">9h30</option>
					<option value="945">9h45</option>
					<option value="10">10h00</option> 
				</select> 
			</div>
			
			<div class="matos">
			 <label class="switch-button small" for="material">
                <input type="checkbox" id="material" name="material" value="yes" <?php if(isset($_POST['material'])) echo "checked='checked'"; ?> >
                <span>Matériel           
                    <span>Non</span>
                    <span>Oui</span>
                </span>
                <a class="btn btn-primary"></a>
              </label>
			</div>
			
			<div class="initiation">
			 <label class="switch-button small" for="initiation">
                <input type="checkbox" id="initiation" name="initiation" value="yes" <?php if(isset($_POST['initiation'])) echo "checked='checked'"; ?> >
                <span>Proposer une initiation ? 
                    <span>Non</span>
                    <span>Oui</span>
                </span>
                <a class="btn btn-primary"></a>
              </label>
              <p>(Votre statut deviendra "professeur")</p>
			</div>
		</section>
        
        <section>
            <button id="spotStep3" class="" ><a href="placerMarqueur2.php">Suivant</a></button>
		</section>
	</aside>

	<!-- STEP 3 -->

	<aside id="detailSpot" class="hidden">
		<nav>
			<ul>
				<li><a href="accueilCarte.php"><img src="img/precedent.svg" alt="Page précédente" /></a></li>
				<li><a href="#"><img src="img/close.svg" alt="fermer" /></a></li>
			</ul>
		</nav>
		
		<section class="lieu">
			<h3>Parc ML Kingk</h3>
			<p>26.10.2013 - 14h30.17h30</p>
		</section>

		<section class="categories">
			<h2><strong>Catégories</strong> pratiquées</h2>
			<div class="clearfix">
				<li class="skill shortline" data-type="shortline">Shortline</li>
				<li class="skill trickline" data-type="trickline">Trickline</li>
				<li class="skill jumpline" data-type="jumpline">Jumpline</li>
				<li class="skill longline" data-type="longline">Longline</li>
				<li class="skill highline" data-type="highline">Highline</li>
				<li class="skill blindline" data-type="blindline">Blindline</li>
				<li class="skill waterline" data-type="waterline">Waterline</li>
			</div>
			<button name="editSkills" class="hidden">Enregistrer les modifications</button>
		</section>

		<section class="noteDepart">
			<h2><strong>Note</strong> de départ</h2>
			<div class="etoile">[class="étoile"]</div>
			<p>Votre note : [Note]</p>
		</section>

		<section class="description">
			<h2><strong>Description</strong></h2>
			<textarea placeholder="Quels sont les point positifs de ce spot ?" rows="5" class="descriptionSpot" id="descriptionSpot"></textarea>
		</section>
		
		<section class="suivant">
			<button name="next" class="">Suivant</button>
		</section>

	</aside>

	
	<div class="reseauxSociaux">
		<ul>
			<li class="fb"><a href="https://www.facebook.com/asso.parislack" target="_blank"></a></li>
			<li class="twitter"><a href="#" target="_blank"></a></li>
			<li class="google"><a href="#" target="_blank"></a></li>
		</ul>
	</div>

	<!-- FIN FUSION CODE AUDREY -->
	
	<?php $img_profil = imageExists(); ?>
	<img src="<?php if($img_profil){ echo $img_profil; } ?>" id="profilDisplay" alt="Accéder à mon profil"/>

	<aside id="profil">

		<section class="infos">
			<figure>
				<img src="upload/default.jpg" alt="Photo de profil" />
				<div></div>
				<figcaption>
					
				</figcaption>
			</figure>
			<div>
				<span></span>
				<span></span>
			</div>
			<div></div>
			<label for="phone">Téléphone :</label>
			<input type="tel" name="phone" id="phone" class="uneditable" placeholder="Téléphone" pattern='^[0-9]{10}$' disabled />

			<label for="email">Email :</label>
			<input type="email" name="email" id="email" class="uneditable" disabled />

			<button id="editProfil" class="" >Modifier mon profil</button>

			<div align="center" class="editProfilImage hidden">
				<form action="processupload.php" method="post" enctype="multipart/form-data" id="uploadForm">
					<input name="ImageFile" type="file" />
					<input type="submit"  id="submitButton" value="Upload" />
				</form>
			</div>

		</section>

		<section class="skills">
			<h2><strong>Catégories</strong> pratiquées</h2>
			<div class="clearfix">
				<li class="skill shortline" data-type="shortline">Shortline</li>
				<li class="skill trickline" data-type="trickline">Trickline</li>
				<li class="skill jumpline" data-type="jumpline">Jumpline</li>
				<li class="skill longline" data-type="longline">Longline</li>
				<li class="skill highline" data-type="highline">Highline</li>
				<li class="skill blindline" data-type="blindline">Blindline</li>
				<li class="skill waterline" data-type="waterline">Waterline</li>
			</div>
			<button name="editSkills" class="hidden">Enregistrer les modifications</button>
		</section>

		<section class="spotsFav">
			<h2><strong>Spots</strong> favoris</h2>
			<input type="text" class="searchSpot" id="searchSpot" placeholder="Rechercher des spots" />
			<label for="searchSpot" class='btn-search'/>Rechercher</label>
			<div id="resultSpots"></div>

		</section>

		<section class="slackersFav">
			<h2><strong>Slackers</strong> favoris</h2>

			<input type="text" class="searchUser" id="searchUser" placeholder="Rechercher des slackers" />
			<label for='searchUser' class='btn-search'>Rechercher</label>
			<div id="resultUsers"></div>
		</section>

		<a href="#" id="logout">Déconnexion</a>


	</aside>


<?php
}

// Sinon redirection
else{

	header("Location: ./login.php");
	exit;
	
}


?>



<?php include('footer.php'); ?>