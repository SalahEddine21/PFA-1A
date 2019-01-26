<?php
	session_start();
	if(!isset($_SESSION['idemp']) or !isset($_POST['nombre_f'])) header('location:Inscription.php');
 	 try
 	 {
 		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
 	 }catch(Exception $e)
 	 {
 	 	echo 'Error: '.$e.getmessage();
 	 	exit();
 	 }

 	$query=$bdd->prepare("UPDATE employeurs set confirmation=1 where idemp=? ");
 	$query->execute(array($_SESSION['idemp']));

 	$query=$bdd->prepare("UPDATE employeurs set pass=? where idemp = ? ");
 	$query->execute(array()$_SESSION['idemp'],$_SESSION['pass']);

 	for($i=1;$i<=$_POST['nombre_f'];$i++ ){

 		$query=$bdd->prepare('SELECT id from formation where nom=? ');
 		$query->execute(array($_POST[$i]));
 		$formation=$query->fetch();

 		if(!empty($formation['id'])){
	 		$query=$bdd->prepare('INSERT INTO formation_prof (idprof,idformation) VALUES (?,?) ');
	 		$query->execute(array($_SESSION['idemp'],$formation['id']));
 		}else header('location:empty.php?formation='.$_POST[$i].' ');

 	}
 	header('location:profil.php');
?>
