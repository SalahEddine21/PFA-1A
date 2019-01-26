<?php
	 session_start();
	 if(isset($_SESSION['connexion'])) header('location:profil.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ADS-Emp</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
	 <div class="container">
			<div class="row">
				<nav class="navbar navbar-inverse col-md-12 col-sm-12">
					<ul class="nav navbar-nav">
						<li class="active" ><a href="login.php">Login</a></li>
					</ul>
				</nav>
			 </div>
			 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 5px;">
			 	<div class="jumbotron" style="padding:0.5em; width:1152px; margin-left:-10px;">
			 		<h1>AGS</h1>
			 		<h3 style="color:red;" ><p>Toujours Simple</p></h3>
			 	</div>
			 </header>
			 <section class="row"  >
				 <div class="col-md-5" style="margin-top:50px;">
				 	<img src="images/j1.jpg" class="img-rounded" alt="Administration-logo" >
				 </div>
			 	<form class="col-sm-12 col-md-offset-1 col-md-6  form-horizontal" action="traitement.php" method="post" style="margin-top:50px; " onsubmit="return(test1());" >

				   		<div class="form-group">
				   			<legend style="font-family:'Comic Sans MS';" >Information Personnel</legend>
				   		</div>
				   		<div class="row" style="margin-left:7px;" >
					   		<div class="form-group" id="mail">
					   			<label type="text" class="col-md-2">email: </label>
					   			<div class="col-md-10"><input type="email" id="email" name="email" class="form-control" placeholder="Votre E-Mail" required></div>
					   		</div>
				   		</div>
				   		<div class="row" style="margin-left:7px;" >
				   			<div class="form-group">
				   				<label type="text" class="col-md-2">Pass: </label>
				   			   <div class="col-md-10"><input type="password" id="pass" name="pass" class="form-control" placeholder="Votre Pass" required></div>
				   			</div>
				   		</div>				
				   	<div class="form-group"><input type="submit" id="but" class="pull-right btn btn-default" value="Suivant"></div>		   			 		
			 	</form>
			 </section>
	 </div>
	 <script>
	 	//var id=document.getElementById('help'),email=document.getElementById('email');
	 
	 	function test1()
	 	{
	 		//alert(document.getElementById('email').value);
			if (/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/.test(document.getElementById('email').value)) return true;
			else {
				document.getElementById('mail').className='form-group has-error';
				return false;
			}	 		

	 	}

	 </script>
</body>
</html>
