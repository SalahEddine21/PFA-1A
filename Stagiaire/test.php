<?php
	session_start();
 	 try
 	 {
 		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
 	 }catch(Exception $e)
 	 {
 	 	echo 'Error: '.$e.getmessage();
 	 	exit();
 	 }
 	 $table=$_SESSION['table_bin'];
 	 echo $_SESSION['code'];
 	 
 	 $query=$bdd->prepare("UPDATE $table set nom_binome=?,passB=?,affectation=0,satisfaction=0 where stagiaire1=? or stagiaire2=? ");
 	 $query->execute(array($_POST['nomb'],$_POST['passb'],$_SESSION['code'],$_SESSION['code']));

 	 $query=$bdd->prepare("SELECT id_binome from $table where stagiaire1=? or stagiaire2=? ");
 	 $query->execute(array($_SESSION['code'],$_SESSION['code']));
 	 $ligne=$query->fetch();

 	 $_SESSION['nomb']=$_POST['nomb'];
 	 $_SESSION['idb']=$ligne['id_binome'];

 	 $query=$bdd->prepare("SELECT * from $table where id_binome=? ");
 	 $query->execute(array($_SESSION['idb']));
 	 $ligne=$query->fetch();

 	 $_SESSION['code1']=$ligne['stagiaire1'];
 	 $_SESSION['code2']=$ligne['stagiaire2'];

 	 $_SESSION['connexion']='on';
 	 header('location:profil.php');
?>