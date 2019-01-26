<?php
	session_start();
	if(!isset($_SESSION['connexion'])) header('location:Deconnexion.php');
	$filiere=$_SESSION['filiere'];
	$_SESSION['vue']=1;

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>AGS-ADMIN</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
	<div class="container">
			<div class="row">
				<nav class="navbar navbar-inverse col-md-12 col-sm-12">
					<ul class="nav navbar-nav">
						<li><a href="imports-selection.php">Accueil</a></li>						
					</ul> 
					<a href="Deconnexion.php" class="pull-right" style="margin-top:12px;">Deconnexion</a>
				</nav>
			</div>
			<header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
			 	<div class="jumbotron" style="padding:0.5em; width:1152px; margin-left:-10px;  ">
			 		<h1>AGS</h1>
			 		<h5><p style="color:red" >Espace Administrative</p></h5>
			 	</div>
			 	<h3><p style="margin-top:-10px; font-family: 'Comic Sans MS',Arial, Verdana, sans-serif; " >Ecole Nationale Supérieure d’Informatique et d’Analyse des Systèmes, ENSIAS  </p></h3>
			</header>
			<section>
				<div class="row">
					<div class=" col-sm-12 col-md-10 col-lg-10">
						<h3><p style="font-family: Verdana;" >Les filières citées si dessous n'ont pas des stages suffisants </p></h3>
							<div class="row">
								<div class="alert alert-info col-md-5 " style="margin-left:18px;" >
									<?php
										echo '<ul>';
											for($i=0;$i<sizeof($filiere);$i++)
												echo '<li style="font-family: Verdana; color:gray; " >'.$filiere[$i].'</li>';
										echo '</ul>';		
									?>
								</div>
							</div>
							<div class="row" style="margin-left:18px;"  >
								<p><strong style="color:red; font-family: 'Comic Sans MS';" >Notice: </strong>l'Algorithme d'affectation exige que le nombre des stages doit étre supérieurs ou égale au nombre des binôme dans chanque filière</p>
								<p>Tapez ici pour revenir <button class="btn btn-info" onclick="document.location.href='imports-selection.php'" style="margin-left:25px;" >Page 0</button> </p>
							</div>
					</div>
				</div>
			</section>
	</div>
</body>
</html>			
<?php
unset($_SESSION['filiere']);
?>