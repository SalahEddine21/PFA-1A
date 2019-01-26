<?php

	 if(!isset($_POST['nom']) || !isset($_POST['prenom']) || !isset($_POST['email']) ) header('location:Inscription.php');
 	 try
 	 {
 		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
 	 }catch(Exception $e)
 	 {
 	 	echo 'Error: '.$e.getmessage();
 	 	exit();
 	 }
 	 $query=$bdd->prepare('SELECT * from employeurs where nom=? and prenom=? and email=?');
 	 $query->execute(array($_POST['nom'],$_POST['prenom'],$_POST['email']));
 	 $ligne=$query->fetch();
 	 echo $ligne['nom'].'-'.$ligne['prenom'].'-'.$ligne['email'];
 	 
 	 if(empty($ligne['idemp'])) header('location:Inscription.php');
 	 else{
		session_start();
		$_SESSION['idemp']=$ligne['idemp'];
		$_SESSION['nom']=$_POST['nom'];
		$_SESSION['prenom']=$_POST['prenom'];
		$_SESSION['email']=$_POST['email'];
		$_SESSION['pass']=$_POST['pass'];
		$_SESSION['vue']=0;
		$_SESSION['connexion']='on';
 	 }
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
							<li class="active"><a href="Inscription.php">Inscription</a></li>
							<li><a href="login.php">Login</a></li>					
						</ul> 
					</nav>
				</div>

				<header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
				 	<div class="jumbotron" style="padding:0.5em; width:1152px; margin-left:-10px;  ">
				 		<h1>AGS</h1>
				 		<h5><p style="color:red" >Inscription-etape 2</p></h5>
				 	</div>
				 	<h3><p style="margin-top:-10px; font-family: 'Comic Sans MS',Arial, Verdana, sans-serif; " >Ecole Nationale Supérieure d’Informatique et d’Analyse des Systèmes, <strong style="color:red;" > ENSIAS </strong>  </p></h3>
				</header>

				<section class="row"   >
				<div class="col-sm-12 col-md-4 col-lg-4" style="margin-top:50px;">
					<blockquote>
						<p>l'inscription <strong style="color:red;" >s'annule</strong> si l'étape actuel a était suspendue</p>
					</blockquote>
				</div>
			    	<div class="col-sm-12 col-md-8 col-lg-8" style="margin-top:50px;"  >
							<form  class="form-horizontal" action="enregistrement-prof.php" method="post" >

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
