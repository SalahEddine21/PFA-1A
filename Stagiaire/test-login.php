<?php
 	 try
 	 {
 		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
 	 }catch(Exception $e)
 	 {
 	 	echo 'Error: '.$e.getmessage();
 	 	exit();
 	 }
 	 if(strcmp($_POST['niveau'], '1A')==0){
 	 	 $table='binomes1a';
 	 	 $niveau='1A';
 	 }
 	 else{
 	 	$table='Binomes2A';
 	 	$niveau='2A';
 	 }

 	 $query=$bdd->prepare("SELECT * FROM $table WHERE nom_binome= ?");
 	 $query->execute(array($_POST['nomb']));
 	 $ligne=$query->fetch();

 	 if(empty($ligne)) header('location:login.php');
 	 else{
 	 	  if(strcmp($ligne['passB'] , $_POST['pass'])!=0) header('location:login.php');
 	 	  else{
 	 	  	    session_start();
	 	 	  	$_SESSION['idb']=$ligne['id_binome'];
	 	 	  	$_SESSION['nomb']=$ligne['nom_binome'];
	 	 	  	$_SESSION['niveau']=$niveau;
	 	 	  	$_SESSION['domaine']=$ligne['formation'];
	 	 	  	$_SESSION['code1']=$ligne['stagiaire1'];
	 	 	  	$_SESSION['code2']=$ligne['stagiaire2'];
	 	 	  	$_SESSION['formation']=$ligne['formation'];
	 	 	  	
	 	 	  	$_SESSION['connexion']='on';
	 	 	  	$_SESSION['vue']=0;
	 	 	  	$_SESSION['vue1']=0;
	 	 	  	$_SESSION['vue2']=0;
	 	 	  	//---
	 	 	  	header('location:profil.php');
 	 	  }

 	 }
?>