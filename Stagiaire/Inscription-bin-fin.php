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
 	$stg1=$_SESSION['stagiaire1'];
 	echo $_SESSION['zone'] ;


 	 if($_SESSION['zone'] == 1 ){
 	 	if(strcmp($_SESSION['stagiaire'], $_POST['binome'])!=0){

 	 		$stg1=$_SESSION['stagiaire']; // stagiaire 1
 	 		$bdd->exec("DELETE from $table where stagiaire1=$stg1 ");
 	 		//header('location:out.php');
 	 		echo "DELETED";
 	 	} else{
 	 	 	$formation=$_SESSION['formation'];
 	 	 	$stg1=$_SESSION['stagiaire'];

 	 		$query=$bdd->exec("UPDATE $table set etat=1 where stagiaire1=$stg1 ");
 	 		$query=$bdd->prepare("UPDATE $table set formation=? where stagiaire1=? ");
 	 		$query->execute(array($formation,$stg1));
 	 	 	header('location:enregistrement-binome.php'); 	 		
 	 	}
 	 }else{
 	 		echo $stg1;
 	 		$stg2=$_POST['binome'];
 	 		$formation=$_SESSION['formation'];

 	 		$query=$bdd->exec("UPDATE $table set stagiaire2=$stg2 where stagiaire1=$stg1 ");
 	 		$query=$bdd->prepare("UPDATE $table set formation = ? where stagiaire1=$stg1 ");
 	 		$query->execute(array($formation));
 	 		header('location:validation-binomes.php');
 	 }
?>