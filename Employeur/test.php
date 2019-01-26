<?php
	session_start();

	if(!isset($_POST['email']) OR !isset($_POST['pass']))  header('location:login.php');
	//--
 	try
 	{
 		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
 	}catch(Exception $e)
 	{
 	 	echo 'Error: '.$e.getmessage();
 	 	exit();
 	}
 	//--
 	$query=$bdd->query('SELECT * FROM employeurs');
 	$ligne=$query->fetch();
 	while($ligne AND strcmp($ligne['email'], $_POST['email'])!=0) $ligne=$query->fetch();
 	if(empty($ligne) || strcmp($ligne['email'], $_POST['email'])!=0) 
 	{
 		session_destroy();
 		header('location:login.php');
 	}else{
 		if(strcmp($ligne['pass'], $_POST['pass'])!=0)
 		{
	 		session_destroy();
	 		header('location:login.php');
	 	}
	 	else
	 	{
	 		$_SESSION['nom']=$ligne['nom']; 
	 		$_SESSION['prenom']=$ligne['prenom'];
	 		$_SESSION['pass']=$ligne['pass'];
 			$_SESSION['email']=$_POST['email'];
 			$_SESSION['idemp']=$ligne['idemp'];
 			$_SESSION['connexion']='on';
 			header('location:profil.php');	
	 	}
 	}
?>