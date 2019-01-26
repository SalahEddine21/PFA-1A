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
						<li><a href="Inscription.php">Inscription</a></li>
						<li class="active"><a href="login.php" >Login</a></li>
					</ul>
				</nav>
			 </div>
			 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
			 	<div class="jumbotron" style="padding:0.5em; width:1152px; margin-left:-10px; ">
			 		<h1>AGS</h1>
			 		<h3 style="color:red;" ><p>Toujours Simple</p></h3>
			 	</div>
			 </header>

			 <section class="row">
			 	<div class="col-sm-12 col-md-6 col-lg-6">
			 		<img src="images/employeur.jpg" class="img-rounded" alt="employeur logo">
			 	</div>
				<form class="form-horizontal col-sm-12 col-md-6 col-lg-6" action="test.php" method="post" style="margin-top:30px;" onsubmit="return(test1());" >
					<div class="form-group">
						<legend>Vos Information</legend>
					</div>
					<div class="row">
						<div class="form-group" id="mail">
							<label type="text" class="col-md-2" >Email:</label>
							<div class="col-md-10" id="mail_nv"><input type="text" id="email" name="email" class="form-control" placeholder="Votre Email" required="">  </div>
						</div>
					</div>
				 	<div class="row"> 
			 			<div class="form-group">
			 				<label type="text" class="col-md-2">Pass:</label>
			 				 <div class="col-md-10"><input type="password" id="pass" name="pass" placeholder="Votre Pass" class="form-control" required></div>
			 			</div>
			 		</div>

			 		<div class="form-group">
			 			<button class="btn btn-danger col-md-offset-7 " onclick="document.location.href='Inscription.php'">Créer Compte</button>
			 			<input type="submit" id="but" class="pull-right btn btn-info" value="Connexion">
			 		</div>
				</form>
			 </section>
	 </div>
	 <script>
	  	function test1(){

			if (/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/.test(document.getElementById('email').value)) return true;
			else {
				var span=document.createElement('span');
				//-----
				span.className="help-block ";
				span.appendChild(document.createTextNode('Corrigez l\'erreur s\'il vous plait'));
				//-----
				document.getElementById('mail_nv').appendChild(span);
				document.getElementById('mail').className='form-group has-error has-feedback';
				return false;
			}	 

	  	}
	 </script>
</body>
</html>