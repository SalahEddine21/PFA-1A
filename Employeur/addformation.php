<?php
	session_start();
	if(!isset($_SESSION['connexion'])) header('location:login.php');

 	try
 	{
 		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
 	}catch(Exception $e)
 	{
 	 	echo 'Error: '.$e.getmessage();
 	 	exit();
 	}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>AGS-resultat</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">

	</head>

	<body>

		<div class="container">
				<div class="row">
					<nav class="navbar navbar-inverse col-md-12 col-sm-12">
						<ul class="nav navbar-nav">
							<li><a href="profil.php">Accueil</a></li>						
						</ul> 
						<a href="Deconnexion.php" class="pull-right" style="margin-top:12px;">Deconnexion</a>
					</nav>
				 </div>
				<header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
				 	<div class="jumbotron" style="padding:0.5em; width:1152px; margin-left:-10px;  ">
				 		<h1>AGS</h1>
				 		<h3 style="color:red;" ><p>Bonjour <?php echo $_SESSION['nom'].' '.$_SESSION['prenom'] ?></p></h3>
				 	</div>
				 	<h3><p style="margin-top:-10px; font-family: 'Comic Sans MS',Arial, Verdana, sans-serif; " >Ecole Nationale Supérieure d’Informatique et d’Analyse des Systèmes,<strong style="color:red;" > ENSIAS </strong> </p></h3>
				</header>
				<section class="row">

				 	<div class="col-sm-12 col-md-4 col-lg-4">
					 		<ul class="list-group">
							   <button id="profil" class="list-group-item" onclick="document.location.href='profil.php'">Mon Profil</button>
								<button id="annonce" class="list-group-item" onclick="document.location.href='addannonce.php'">Ajouter une Annonce</button>
								<button id="ensemble" class="list-group-item " onclick="document.location.href='mesannonce.php'">Mes Annonces</button>
								<button id="mesinfos" class="list-group-item  active" onclick="document.location.href='addformation.php'">Ajouter Formation</button>
							</ul>
				 	</div>				
			    	<div class="col-sm-12 col-md-8 col-lg-8" style="margin-top:15px;"  >
							<form  class="form-horizontal" action="enregistrement-formation.php" method="post" >

						    	<fieldset>
						    		<legend>Formations</legend>
								    	<div class="row">
								    		<div  id="form" class="form-group">
								    			<label id="360" type="text" class="col-md-2" style="margin-left:30px;">Formation 1:</label>
								    				<div class=" col-md-9">
													 <input type="text" name="1" class="form-control" placeholder="(SSI,GL,BI...)" required>
													 </div>													
								    		</div>

											<div class="form-group">
												<div class="col-md-2" style="margin-left:30px;" ></div>
												<div class="col-md-9">
														<a class="btn btn-primary col-offset-md-1" onclick="inserer()">Ajouter Input</a>
														<a class="btn btn-danger" onclick="hide()" >Cacher Input</a>
												</div>
											</div>								    		
								    	</div>		
								</fieldset>	
								<input type="hidden" id="nombreformation" name="nombre_f" value="1" hidden>
							
								<input type="submit" id="but" class="btn btn-success col-md-3" value="Valider" style="margin-left:555px;">
							</form>	    		
			    	</div>					
				</section>
		</div>
		<script>
			var i=1,nombre,j=1,k=360 ;
			nombre=document.getElementById('nombreformation');

			function inserer(){
				i++;
				k++;
				j=i;
				nombre.value=i;
				//------------------------------------------------------------//
		  		label=document.createElement('label');
		  		label.type='text';
		  		label.className='col-md-2';
		  		label.style='margin-left:30px;';
		  		label.id=k;
		  		label.appendChild(document.createTextNode('Formation '+i+':'));
		  		//------------------------------------------------------------//
		  		div=document.createElement('div');
		  		div.className='col-md-9';
		  		div.id=j;
		  		//------------------------------------------------------------//
		  		input=document.createElement('input');
		  		input.type="text";
		  		input.className='form-control';
		  		input.name=i;
		  		input.placeholder='(SSI,GL,BI...)';
		  		input.required="required";
		  		//------------------------------------------------------------//
		  		div.appendChild(input);
		  		//------------------------------------------------------------//

		  		fieldset=document.getElementById('form');
		  		fieldset.appendChild(label);
		  		fieldset.appendChild(div);
		  		//------------------------------------------------------------//
			}
			function hide(){
				if(j!=1 && k!=360){
					input=document.getElementById('form');
					label=document.getElementById(k);
					child=document.getElementById(j); // div

					input.removeChild(label);
					input.removeChild(child);
					i=i-1;
					j=j-1;
					k=k-1;
					nombre.value=nombre.value-1;
				}
			}			
		</script>
	</body>
</html>				