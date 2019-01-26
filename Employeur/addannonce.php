<?php
	session_start();
	if(!isset($_SESSION['connexion'])) header('location:login.php');
	//--
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
		<meta charset="utf-8">
		<title>Employeur</title>
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
				 	<div class="jumbotron" style="padding:0.5em; width:1152px; margin-left:-10px;">
				 		<h1>AGS</h1>
				 		<h3 style="color:red;" ><p>Bonjour <?php echo $_SESSION['nom'].' '.$_SESSION['prenom'] ?></p></h3>
				 	</div>
				 	<h3><p style="margin-top:-10px; font-family: 'Comic Sans MS',Arial, Verdana, sans-serif; " >Ecole Nationale Supérieure d’Informatique et d’Analyse des Systèmes,<strong style="color:red;" > ENSIAS </strong> </p></h3>
				 </header>
				 <section class="row">
				 	<div class="col-sm-12 col-md-4 col-lg-4">
				 		<ul class="list-group">
						   <button id="profil" class="list-group-item" onclick="document.location.href='profil.php'">Mon Profil</button>
							<button id="annonce" class="list-group-item active" onclick="document.location.href='addannonce.php'">Ajouter une Annonce</button>
							<button id="ensemble" class="list-group-item " onclick="document.location.href='mesannonce.php'">Mes Annonces</button>
							<button id="mesinfos" class="list-group-item" onclick="document.location.href='addformation.php'">Ajouter Formation</button>
						</ul>
				 	</div>	
				 	<div class="col-sm-12 col-md-8 col-lg-8">
				 	
					<form id="form" class="form-horizontal" action="enregistrement-annonce.php" method="post" onsubmit="return(test());">
			 														<!--Début Du Forme -->
			 		<div id="main">
			 			
			 			<div class="form-group">
			 				<legend>Stage Information</legend>
			 			</div>
			 			<div class="row">
			 				<div class="form-group">
			 					<label type="text" class="col-md-2">Titre</label>
			 					<div class="col-md-10"><input type="text" name="titre" class="form-control" placeholder="Titre Stage" required></div>
			 				</div>
			 			</div>
						<div class="row">
							<div class="form-group">
								<label type="text" class="col-md-2">Description: </label>
								<div class="col-md-10"><textarea type="textarea" name="desc" class="form-control" placeholder="Description du stage" rows=4 required></textarea></div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<label type="text" class="col-md-2">Niveau</label>
								<div class="col-md-10">
									<select name="niveau" class="form-control" required>
										<option value="1A">1A</option>
										<option value="2A">2A</option>
									</select>							
								</div>
							</div>
						</div>
						<?php 
							$query=$bdd->prepare('SELECT nom from formation where id in (select idformation from formation_prof where idprof=? ) ');
							$query->execute(array($_SESSION['idemp']));
						?>
						<div class="row">
							<div class="form-group">
								<label type="text" class="col-md-2">Formation</label>
								<div class="col-md-10">
									<select name="formation" class="form-control" required>
									<?php while($ligne=$query->fetch()){
										 echo "<option value=".$ligne['nom'].">".$ligne['nom']."</option>";
										} ?>

									</select>							
								</div>
							</div>
						</div>	

						<div id="addmod">

								<div class="row">
									<div class="form-group">
										<label type="text" class="col-md-2">Module 1:</label>
										<div class="col-md-10">
											<select id="100" name="1" class="form-control" required >
												<option value="M1">M1</option>
												<option value="M2">M2</option>
												<option value="M3">M3</option>
												<option value="M4">M4</option>
												<option value="M5">M5</option>
												<option value="M6">M6</option>
												<option value="M7">M7</option>
												<option value="M8">M8</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<label type="text" class="col-md-2">poid:</label>
										<div class="col-md-10">
											<input id="11" type="text" name="11" class="form-control" placeholder="0.0" >
										</div>
									</div>
								</div>

						</div>

						<div class="row">
							<div class="form-group">
								<div class="col-md-2"></div>
								<div class="col-md-10">
										<a class="btn btn-primary col-offset-md-1" onclick="inserer()">Ajouter Module</a>
										<a class="btn btn-danger" onclick="hide()" >Cacher Module</a>
								</div>
							</div>
						</div>
			 		</div>
			 			<input type="hidden" id="nombrechoix" name="nombrechoix" value="1" hidden>

			 			<div class="row">
		  		  		  <div class="form-group">
							<input type="submit" id="but" class="pull-right btn btn-success" value="Enregistrer">
		  				  </div>
			 			</div>
		  				  
		  				 										 <!--Fin Du Forme -->
			 		</form>			 		
				 	</div>			 	
				 </section>
		</div>
		<script>

	  	var i=100,j=11,id=1,idp=360;
	  	var choixnombres=document.getElementById('nombrechoix');
	  	function inserer()
	  	{ 
	  		i++;//les names des selections;
	  		j++;//les names des inputs
	  		id++;
	  		idp++;
	  		//--
	  		choixnombres.value=id;
	  		//--------------------Insertione de la selection------------//
	  		divrow=document.createElement('div');
	  		divrow.className='row';
	  		divrow.id=id;
	  		//----
	  		divformgroup=document.createElement('div');
	  		divformgroup.className='form-group';
	  		//--
	  		label=document.createElement('label');
	  		label.type='text';
	  		label.className='col-md-2';
	  		label.appendChild(document.createTextNode('Module '+id+':'))
	  		//label.value='Module';
	  		//--
	  		divcolmd10=document.createElement('div');
	  		divcolmd10.className='col-md-10';
	  		//-----------------------------------------//
	  		select=document.createElement('select');
	  		select.name=id;
	  		select.id=i;
	  		select.className='form-control';
	  		//--
	  		m1=document.createElement('option');
	  		m1.value='M1';
	  		m1.appendChild(document.createTextNode('M1'));
	  		//--
	  		m2=document.createElement('option');
	  		m2.value='M2';
	  		m2.appendChild(document.createTextNode('M2'));
	  		//---
	  		m3=document.createElement('option');
	  		m3.value='M3';
	  		m3.appendChild(document.createTextNode('M3'));
	  		//--
	  		m4=document.createElement('option');
	  		m4.value='M4';
	  		m4.appendChild(document.createTextNode('M4'));
	  		//---
	  		m5=document.createElement('option');
	  		m5.value='M5';
	  		m5.appendChild(document.createTextNode('M5'));
	  		//--
	  		m6=document.createElement('option');
	  		m6.value='M6';
	  		m6.appendChild(document.createTextNode('M6'));
	  		//--
	  		m7=document.createElement('option');
	  		m7.value='M7';
	  		m7.appendChild(document.createTextNode('M7'));
	  		//--
	  		m8=document.createElement('option');
	  		m8.value='M8';
	  		m8.appendChild(document.createTextNode('M8'));
	  		//-----------------------------------------//
	  		select.appendChild(m1);
	  		select.appendChild(m2);
	  		select.appendChild(m3);
	  		select.appendChild(m4);
	  		select.appendChild(m5);
	  		select.appendChild(m6);
	  		select.appendChild(m7);
	  		select.appendChild(m8);
	  		//-----------------------------------------//
	  		divcolmd10.appendChild(select);
	  		//-----------------------------------------//
	  		divformgroup.appendChild(label);
	  		divformgroup.appendChild(divcolmd10);
	  		divrow.appendChild(divformgroup);
	  		//-----------------------------------------//
	  		//ctrl=document.createElement('br');
	  		//ctrl.id='ctrl';
			//-----------------Insertion de la zone de saisie du poids-------------------//
			divrow1=document.createElement('div');
			divrow1.className='row';
			divrow1.id=idp;
			//--
			divformgroup1=document.createElement('div');
			divformgroup1.className='form-group';
			//--
			label1=document.createElement('label');
			label1.className='col-md-2';
			label1.appendChild(document.createTextNode('Poid: '));
			//--
			divcolmd2=document.createElement('div');
			divcolmd2.className='col-md-10';
			//--
			input1=document.createElement('input');
			input1.className='form-control';
			input1.type='text';
			input1.name=j;
			input1.id=j;
			input1.placeholder='0.0';
			input1.required="required";
			//--
			divcolmd2.appendChild(input1);
			//--
			divformgroup1.appendChild(label1);
			divformgroup1.appendChild(divcolmd2);
			//--
			divrow1.appendChild(divformgroup1);
			//----------------------le tous dans l'element <div id='addmod'>-----//
	  		//document.getElementById('addmod').appendChild(ctrl);
	  		document.getElementById('addmod').appendChild(divrow);
	  		document.getElementById('addmod').appendChild(divrow1);		
	  	}
	  	function test()
	  	{
	  		var ind,p,select,nextselect,boolean=false,u,bound;  var s = new Number('0');
	  		//alert(parseInt(choixnombres.value)+100);
	  		for(ind=100; ind< i ; ind++)
	  		{
	  			select=document.getElementById(ind);
	  			for(p=ind+1; p <= i ; p++)
	  			{
	  				nextselect=document.getElementById(p);
	  				if(select.options[select.selectedIndex].innerHTML==nextselect.options[nextselect.selectedIndex].innerHTML) boolean=true;
	  			}
	  		}
	  		for(ind=11 ; ind <= j ; ind++) s=s+parseFloat(document.getElementById(ind).value);

	  		if(parseFloat(s) != 1.0){
	  			alert('la somme des poids doit être égale à 1 !');
	  			return false;
	  		}

	  		if(boolean==true) {
	  			alert('Certains modules ont étaient redoublés  ')
	  			return false;
	  		}
	  		return true;
	  	}
	  	function hide()
	  	{
	  		if(id!=1 && idp!=360 ){
	  			main=document.getElementById('addmod');
	  			child=document.getElementById(id);
	  			child1=document.getElementById(idp);
	  			//ctrl=document.getElementById('ctrl');
	  			//--
	  			id=id-1;
	  			idp=idp-1;
	  			i=i-1;
	  			j=j-1;
	  			//--
	  			main.removeChild(child);
	  			main.removeChild(child1);
	  			//main.removeChild(ctrl);
	  			parseInt(choixnombres.value)=parseInt(choixnombres.value)-1;
	  			//document.getElementById('addmod').removeChild(idpoids);
	  		}
	  	}
		</script>		 		
	</body>
</html>	