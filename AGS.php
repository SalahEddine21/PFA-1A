<!DOCTYPE html>
<html>
<head>
	<title>AGS</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">


</head>
<style>

</style>
<body  >
	<div>
		<header class="row" style=" background-color: #1abc9c; width: 100%; margin-left: 1px; " >
			<h1 class="active" style="margin-left:25px; margin-top: 18px; " ><a class="pull-left" style="color:black; font-family: 'Comic Sans MS';" href="AGS.php" >Acceuil</a></h1>
			<nav  class="pull-right" style="display: inline-block; margin-top: 0px; ">
				<ul class="nav nav-tabs" style="list-style-type: none;">
					<li style="display: inline-block; "><a href="About.html" style=" color:black;" >About</a></li>
					<li style="display: inline-block; "><a href="Contact.html" style=" color:black;">Contact</a></li>
				</ul>
			</nav>
	        <div class="text-center" style=" margin-top: 190px; margin-bottom:150px;">
	        	<img src="croped.png" class="img-circle" alt="ensias-logo.jpg" >
	            <h2 ><p  style="color:black; font-family: 'Comic Sans MS';  font-size: 500%; margin-top: " >AGS</p></h2>
	            <h4><p style="color:#272833; font-size:250%; margin-top:30px; font-family: 'Comic Sans MS' ; " >Votre Application d'affectation la plus Simple</p></h4>
	         
	        </div>
		</header>

 	   <section id="services" style="margin-top:-8px;">
	        <div class="container">
	            <div class="row">
	                <div class="col-lg-12 text-center">
	                    <h2 class="section-heading" style="font-family: 'Comic Sans MS'; font-size: 50px; " >Services</h2>
	                    <h3 class="section-subheading text-muted">Choisissez Votre Catégorie</h3>
	                </div>
	            </div>
	            <div class="row text-center">
	                <div class="col-md-4">
	            	    <button class="btn btn-primary btn-lg" style="font-size:30px; margin-top: 25px; "  onclick="document.location.href='Stagiaire/Inscription.php'"  >Etudiants</button>
	                    <h4 class="service-heading">Espace Etudiants</h4>
	                    <p style="font-size:16px;" >Tapez Sur dessous si vous êtes un étudiant</p>
	                </div>
	                <div class="col-md-4">
	            	    <button class="btn btn-info btn-lg" style="font-size:30px; margin-top: 25px;"  onclick="document.location.href='Employeur/Inscription.php'"   >Professeurs</button>
	                    <h4 class="service-heading">Espace Professeurs</h4>
	                    <p style="font-size:16px;" >Tapez Sur dessous si vous êtes un Professeur</p>
	                </div>
	                <div class="col-md-4">
	            	    <button class="btn btn-danger btn-lg" style="font-size:30px; margin-top: 25px; "  onclick="document.location.href='Administrateur/login.php'"  >Administrateur</button>
	                    <h4 class="service-heading" >Espace Administrative</h4>
	                    <p style="font-size:16px;" >Tapez Sur dessous si vous êtes l'Administrateur</p>
	                </div>
	            </div>
	        </div>
   		 </section>
    </div>
    <div class="container">
    	<section class="row">
    		<p></br></p>
    		<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">Algorithme et Contrainte</h3>
				</div>
				<div class="panel-body">
					<h3 style="color:red;">Principe de l'Algorithme</h3>
					<p>L'algo d'affectation est basé sur le principe de celui du GALE-SHAPLEY , il commance par un tri des notes que chaque stagiaire disposent dans chaque stage qu'il a choisit, ainsi on l'affecte <strong>temporairemnt</strong> au première stage dans ça liste (après tri) , donc c'est fortement <strong>recommandée</strong> au stagiaires que leurs premières choix doivent être des stages dont ils ont une bonne nôte (la plus bonne nôte si possible), pour avoir une satisfaction satisfaisante.
					si deux stagiaires ont fait le même choix (stage debordant) on affecte le stage a celui qui a la nôte supérieure à l'autre, s'ils ont la même nôte on passe par l'aléatoire entre eux.
					toujours on affecte les stages aux etudiants qu'ils les ont demandès et ayant une nôte supèrieure par rapport au autre dans chacun d'eux.</p>
					<h3 style="color:red;" >Contraintes</h3>
					<ul>
						<li>Le nombre des stages dans chaque filière doit être <strong> supérieur ou égale </strong> au nombre des Binômes dans la dite filière .</li>
						<li>Chaque Stage peut s'affecter a un et un seul Binôme et respectivement</li>
						<li><strong style="color:blue;" >Stagiaires: </strong>Attention au decoulement du temps,Soyez Vigilant ;)</li>
					</ul>
					<small class="pull-right">Ensias-2017</small>
				</div>   			
    		</div>
    	</section>
			 
			<footer class="row" style="background-color: gray; margin-top: 20px; border-radius: 10px; "  >
				<div class=" col-md-6" >
					<form class="form-horizontal col-md-offset-1 " action="equipe-msg.php" method="post" >
						</br>
						<legend style="color:black; margin-left: -10px; font-family: 'Comic Sans MS' " >Laisser nous un message </legend>

			 			<div class="row" style="margin-left:5px;" >
			 				<div class="form-group">
			 				     <div class="col-md-11"><input type="text" id="email" name="email" placeholder="Votre Email" class="form-control" required></div>
			 				</div>
			 			</div>
			 			<div class="row" style="margin-left:5px;" >
			 				<div class="form-group">
			 					<div class="col-md-11">
									<textarea id="textarea" rows="5" class="form-control" style="width:100%;" placeholder="Votre Message" ></textarea>		
			 					</div>
			 				</div>
			 			</div>
			 			<div class="row">
			 				<button type="submit" class=" col-md-offset-9 btn btn-primary  ">Envoyer</button>
			 			</div>
						</br>
					</form>
				</div>

				<div class=" col-md-offset-1 col-md-4" style="color:black; background-color:white; border-radius:10px; margin-top:80px; " >
					<address>
							</br>
							<strong><p>email: AGS-ENSIAS.17@gmail.com </p></strong>
							<p>Developped By :SalahEddine-Youssef Ms</p><p>&copy; AGS. All rights reserved.</p>
						</div>
					</address>				
				</div>

			</footer> 

    </div>

</body>
</html>