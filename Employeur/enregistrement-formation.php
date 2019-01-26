<?php
	session_start();
	if(!isset($_SESSION['connexion'])) header('location:login.php');

	try
 	{
 		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
 	}catch(Exception $e)
 	{
 	 	echo 'Error: '.$e.getmessage();
 	 	exit();
 	}
 	
 	function exist($formation,$bdd){
	 	$query=$bdd->query('SELECT nom from formation');
	 	while($ligne=$query->fetch()){
	 		if(strcmp($ligne['nom'], $formation)==0) return true;
	 	}
	 	return false;
 	}

 	function old($formation,$bdd){
 		$query=$bdd->prepare('SELECT nom from formation where id in (select idformation from formation_prof where idprof = ? ) ');
 		$query->execute(array($_SESSION['idemp']));

 		while($ligne=$query->fetch()){
 			if(strcmp($ligne['nom'] , $formation)==0) return true;
 		}
 		return false;
 	}

 	$old_a=array(); $k=0;
 	$nexist=array(); $m=0;

 	for($i=1;$i<=$_POST['nombre_f'];$i++){

 		if(exist($_POST[$i],$bdd)){
 			echo "string";
			if(!old($_POST[$i],$bdd)){
	 			$id=$bdd->prepare('SELECT id from formation where nom=?');
	 			$id->execute(array($_POST[$i]));
	 			$id=$id->fetch();

	 			$query=$bdd->prepare('INSERT INTO formation_prof (idprof,idformation) values (?,?) ');
	 			$query->execute(array($_SESSION['idemp'],$id['id']));
 			}else{
 				$old_a[$k]=$_POST[$i];
 				$k=$k+1;
 			}

 		}else{
 			$nexist[$m]=$_POST[$i];
 			$m=$m+1;
 		} 
 	}

 	$_SESSION['old']=$old_a;
 	$_SESSION['nexist']=$nexist;

 	header('location:formation_stocked.php');

?>