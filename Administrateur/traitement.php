<?php
     try
     {
		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
     }catch(Exception $e)
     {
     	echo 'Error : '.$e.getmessage();
     }

     $query=$bdd->query('SELECT * FROM Administrateur');
     $ligne=$query->fetch();
     if(empty($ligne)) 
     {
     	$query=$bdd->prepare('INSERT INTO Administrateur(email,pass) VALUES (?,?) ');
     	$query->execute(array($_POST['email'],$_POST['pass']));
     }else{
        if(strcmp($ligne['email'], $_POST['email'])!=0 || strcmp($ligne['pass'], $_POST['pass'])!=0) header('location:Login.php');
        else{
         	 //--------------------------------------//
			session_start();
			$_SESSION['email']=$_POST['email'];
            $_SESSION['connexion']='on';
            $_SESSION['vue']=0;
			header('location:imports-selection.php');
        }
     }

?>