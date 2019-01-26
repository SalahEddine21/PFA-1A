<?php
	session_start();
	if(!isset($_SESSION['connexion'])) header('location:Deconnexion.php');
     try
     {
		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
     }catch(Exception $e)
     {
     	echo 'Error : '.$e.getmessage();
     }
	 //--------------------------------------//
	 if(!isset($_POST['nombre_f']) or !is_numeric($_POST['nombre_f'] ) ) header('location:addformation.php');

	for($i=1;$i<=$_POST['nombre_f'];$i++) {
		$query=$bdd->prepare("INSERT INTO formation(nom) VALUES (?) ");
		$query->execute(array($_POST[$i]));
	}
	$_SESSION['vue']=1;

?>