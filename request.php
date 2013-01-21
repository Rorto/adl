<?php
require('../adodb5/adodb.inc.php');

//fonction de création de la page
function page($type, $bonus){
	switch($type){
		// une erreur
		case 'error':
			$pageTitle = 'Erreur';
			
			//le type d'erreur
			switch($bonus){
				case 'bdd':
					$errorMessage = 'La demande n\'a pas été enregistrée, réessayez ultérieurement.';
					break;
				case 'empty request':
					$errorMessage = 'La requète est vide, concentrez-vous.';
					break;
				case 'anonemail':
					$errorMessage = 'Vous n\'avez ni fourni d\'adresse email ni demandé de rendre la demande anonyme, vérifiez votre saisie.';
					break;
				default:
					$errorMessage = 'Une erreur est survenue, vérifiez la saisie et réessayez ultérieurement.';
			}
			
			$body = '
	<div class="container">
		<h2>Erreur</h2>
		<p>La demande n\'a pas été correctement digérée.<br/>
			Message d\'erreur : '.$errorMessage.'
		<br/><br/>
		<a href="javascript:history.back()" class="btn btn-large btn-primary">Retour</a></p>
	</div>
					';	
			break;
		// une saisie de demande
		case 'newrequest':
			$pageTitle = 'Faire une demande';
			$body = '
<div class="jumbotron masthead">
	<div class="container" style="text-align: left; color: #5a5a5a;">
		
	  <form action="request?n" method="post" class="form-request">
		<h2 class="form-request-heading">Votre demande :</h2>
		<input type="text" class="input-block-level" name="request" placeholder="Nom, date, détails significatifs si besoin">
		<input type="text" name="email" placeholder="Adresse email">
		<label class="checkbox">
		  <input type="checkbox" name="anon"> Ceci est une demande anonyme
		</label>
		<button class="btn btn-primary btn-large" type="submit">Envoyer</button>
	  </form>
	
	</div> <!-- /container -->
</div>
					';
			break;
		// enregistrement demande OK
		case 'success':
			$pageTitle = 'Votre demande';
			$body = '
<header class="jumbotron subhead" id="overview">
  <div class="container">
	<h1>Demande enregistrée</h1>
	<p class="lead">Enregistrez-vous pour suivre facilement toutes vos demandes !</p>
  </div>
</header>
	<div class="container" style="text-align: left; color: #5a5a5a;">
		<div class="row">
		<div class="span3 bs-docs-sidebar">
			<p>Menu</p>
			<p>
				<a href="register" class="btn btn-large btn-primary">Créer un compte</a></br>
				<a href="request" class="btn btn-large btn-primary">Créer une nouvelle demande</a>
			</p>
				
			
		</div>
		<div class="span9">
		
		  <section id="request-links">
			<div class="page-header">
			  <h1>Votre demande :</h1>
			</div>
			<p class="lead">Enregistrez-vous et gardez trace de vos demandes.</p>
		
			<div class="row-fluid">
			  <div class="span6">
				<h2>Affichez les détails de votre demande</h2>
				<p><a href="request.php?r='.$bonus.'" class="btn btn-large btn-primary">Votre demande</a></p>
			  </div>
			  <div class="span6">
				<h2>Recommencer</h2>
				<p><a href="request" class="btn btn-large btn-primary">Créer une nouvelle demande</a></p>
			  </div>
			</div>
		  </section>
		</div>
	</div>
</div>
					';
			break;
		// affichage d'une demande
		case 'request':
			// permet de décomposer le tableau de réponse, méthode miracle
			foreach($bonus as $rows){ 
				print_r($rows); 
			}
			
			if($rows['id'] != NULL){ //on vérifie que la demande existe
				$pageTitle = 'Demande';
				$body = '
	<div class="container">
		<h2>Votre demande</h2>
		<p>'.$rows['content_request'].'</p>
		<h2>État</h2>
		<p>'.$rows['state_id'].'</p>
		<p>Demande n°'.$rows['id'].' ajoutée le '.$rows['date'].'.</p>
	</div>
						';
				if ($rows['email'] == NULL){
					$body .= '<p>Demande anonyme</p>';
				}
			}else{
				$pageTitle = 'Demande introuvable';
				$body = '
	<div class="container">
		<h2>La demande n\'a pas été trouvée ou n\'existe pas.</h2> 
		<p>Vérifiez l\'adresse saisie.<br/></p>
		<p><a href="index" class="btn btn-large btn-primary">Accueil</a></p>
						';
			}
				
			break;
		default:
			$pageTitle = 'ToDo';
			$body = '
					<div class="container">
						<h2>Erreur</h2>
						<p><br/><br/><a href="javascript:history.back()" class="btn btn-large btn-primary">Retour bug</a></p>
					</div>
					';	
			break;
	}
	
	//construction de la page html
	$page = '<!DOCTYPE html>
<html lang="fr">
  <head>
	<meta charset="utf-8">
		';
	$page .= '
	<title>'.$pageTitle.' &middot; Torrentsic</title>';
	$page .= '
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Le styles -->
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<style type="text/css">
	  body {
		padding-top: 40px;
		padding-bottom: 40px;
		background-color: #f5f5f5;
	  }
	
	  .form-request {
		max-width: 900px;
		padding: 19px 29px 29px;
		margin: 0 auto 20px;
		background-color: #fff;
		border: 1px solid #e5e5e5;
		-webkit-border-radius: 5px;
		   -moz-border-radius: 5px;
				border-radius: 5px;
		-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
		   -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
				box-shadow: 0 1px 2px rgba(0,0,0,.05);
	  }
	  .form-request .form-request-heading,
	  .form-request .checkbox {
		margin-bottom: 10px;
	  }
	  .form-request input[type="text"] {
		font-size: 16px;
		height: auto;
		margin-bottom: 15px;
		padding: 7px 9px;
	  }
	
	</style>
	<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="assets/css/docs.css" rel="stylesheet">
	<link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
  </head>

  <body>


  <!-- Navbar
  ================================================== -->
  <div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
	  <div class="container">
		<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		</button>
		<a class="brand" href="./index">Torrentsic</a>
		<div class="nav-collapse collapse">
		  <ul class="nav">
			<li class="">
			  <a href="./index">Accueil</a>
			</li>
			<li class="active">
			  <a href="./request">Faire une demande</a>
			</li>
		  <li class="">
			<a href="./signin">Se connecter</a>
		  </li>
		  <li class="">
			<a href="./about">À propos</a>
		  </li>
		  </ul>
		</div>
	  </div>
	</div>
  </div>';	
	$page .= $body; //ajout de la partie variable
	$page .= '
	<footer class="footer">
	  <div class="container">
		<p class="pull-right"><a href="#">Haut de page</a></p>
		<p>Copie conforme et assumée du <a href="http://twitter.github.com/bootstrap/" target="_blank">site de Bootstrap</a> par <a href="http://twitter.com/rorto" target="_blank">@rorto</a>.</p>
		<p>Code licensed under <a href="http://www.apache.org/licenses/LICENSE-2.0" target="_blank">Apache License v2.0</a>, documentation under <a href="http://creativecommons.org/licenses/by/3.0/">CC BY 3.0</a>.</p>
		<p><a href="http://glyphicons.com">Glyphicons Free</a> licensed under <a href="http://creativecommons.org/licenses/by/3.0/">CC BY 3.0</a>.</p>
	  </div>
	</footer>
	

	<!-- Le javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/bootstrap-transition.js"></script>
	<script src="assets/js/bootstrap-alert.js"></script>
	<script src="assets/js/bootstrap-modal.js"></script>
	<script src="assets/js/bootstrap-dropdown.js"></script>
	<script src="assets/js/bootstrap-scrollspy.js"></script>
	<script src="assets/js/bootstrap-tab.js"></script>
	<script src="assets/js/bootstrap-tooltip.js"></script>
	<script src="assets/js/bootstrap-popover.js"></script>
	<script src="assets/js/bootstrap-button.js"></script>
	<script src="assets/js/bootstrap-collapse.js"></script>
	<script src="assets/js/bootstrap-carousel.js"></script>
	<script src="assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>
			';
	
	//affichage de la page construite
	echo $page;
}  

//vérifications du formulaire
if (isset($_GET['n'])){ //request.php en mode nouvelle demande
	if (isset($_POST['request'])){
		$request=htmlentities($_POST['request']);
		$email=htmlentities($_POST['email']);
		if ($request != NULL){
			if (($email == NULL) && !isset($_POST['anon'])){ //mail est vide et !anon
				page('error', 'anonemail');
			}
			else {
				$DB = NewADOConnection('mysql');
				$DB->Connect('localhost', 'root', '', 'adl');
				
				$dbinsert = "INSERT INTO `requests` (`id`, `content_request` ";
				if (($email != NULL) && !isset($_POST['anon'])){
					$dbinsert .= ", `email`";
				}
				$dateinsert = date('Y-m-d H:i:s');
				$dbinsert .= ", `date`, `state_id`, `user_id`) VALUES ('','$request'";
				if (($email != NULL) && !isset($_POST['anon'])){
					$dbinsert .= ", '$email'";
				}
				$dbinsert .= ", '$dateinsert', '1', '1')";
								
				$rs = $DB->Execute($dbinsert);
				
				echo $DB->ErrorMsg();
								
				//sort la dernière entrée en base. faible mais suffisant pour commencer
				//------		------
				//		A REVOIR
				//------		------
				$rsid = $DB->Execute("SELECT * FROM requests ORDER BY id DESC LIMIT 0, 1");
				//echo $requestId['id'];		
				echo $DB->ErrorMsg();
				
				//attrappe la valeur de l'id de la dernier entrée dans la base
				$array = $rsid->FetchRow();
				$requestId = $array['id'];
								
				if($rs){
					page('success', $requestId);
				}else page('error', 'bdd');
			}
		}else page('error', 'empty request');
	}else page('error');
}else if (isset($_GET['r'])){ //request.php en mode affichage d'état d'une demande
	$requestId = htmlentities($_GET['r']);
	$DB = NewADOConnection('mysql');
	$DB->Connect('localhost', 'root', 'root', 'adl');

	$rs = $DB->Execute("SELECT * FROM requests WHERE id=$requestId");
	
	if ($rs){
		page('request', $rs);
	}else page('error');
}else page('newrequest',''); //pas ou mauvais mode d'affichage défini donc on envoi le formulaire
?> 