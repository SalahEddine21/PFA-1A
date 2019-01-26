<?php
	 //-----------------------------------------------------------------------------------------------------------------------------**
 	 try
 	 {
 		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
 	 }catch(Exception $e)
 	 {
 	 	echo 'Error: '.$e.getmessage();
 	 	exit();
 	 }


 	 if(strcmp($_POST['niveau'], '1A')==0){
 	 $query=$bdd->prepare('SELECT * FROM etudiants1a WHERE nom=? and prenom=?');
 	 $query->execute(array($_POST['nom'],$_POST['prenom']));
 	 $ligne=$query->fetch();
 	 if( empty($ligne['codeEtudiant']) or strcmp($_POST['email'] , $ligne['email'])!=0 ) header('location:Inscription.php');
 	 $table='etudiants1a';
 	 $binome='Binomes1A';
 	 $niveau='1A';
 	 }
 	 else if(strcmp($_POST['niveau'], '2A')==0){
 	 $query=$bdd->prepare('SELECT * FROM etudiants2a WHERE nom=? and prenom=?');
 	 $query->execute(array($_POST['nom'],$_POST['prenom']));
 	 $ligne=$query->fetch();
 	 $table='etudiants2a';
 	 $binome='Binomes2A';
 	 $niveau='2A';
 	 }

 	 $etat=$bdd->prepare("SELECT * from $binome where stagiaire1=? or stagiaire2=? ");
 	 $etat->execute(array($ligne['codeEtudiant'],$ligne['codeEtudiant']));
 	 $etat=$etat->fetch();
 	// if(empty($ligne)) header('location:Inscription.php'); //tmp
     //else{
 	 		
 if(!empty($etat['etat']) && intval($etat['etat'])==1){
 				if(empty($etat['nom_binome']) or empty($etat['passB'])){
	 	 			session_start();
				 	$_SESSION['table'] = $table;
				 	$_SESSION['table_bin'] = $binome;
				 	$_SESSION['niveau'] = $niveau;
				 	$_SESSION['formation'] = $ligne['formation'];
				 	$_SESSION['prenom'] = $ligne['prenom'];
				 	$_SESSION['code'] = $ligne['codeEtudiant'];
	 	 			header('location:enregistrement-binome.php');
 	 			}else header('location:login.php');
 }else{

	  	 	$query=$bdd->prepare("SELECT * FROM $table WHERE codeEtudiant=?");
	 	 	$query->execute(array($ligne['codeEtudiant']));
	 	 	$ligne=$query->fetch();
	 	 	//if($ligne['confirmation']==1) echo "string"; // tmp

 		    //else{
 		    session_start();
 			//$query=$bdd->prepare('INSERT INTO stagiaires(code,nom,prenom,niveau,email,domaine,pass) VALUES (?,?,?,?,?,?,?) ');
	//$query->execute(array($_POST['code'],$_POST['nom'],$_POST['prenom'],$_POST['niveau'],$_POST['email'],$_POST['domaine'],$_POST['pass']));
		 	 //--
 		    $code=$ligne['codeEtudiant'];
 		    echo $code;


 		    $bdd->exec("UPDATE $table set confirmation=1 where codeEtudiant=$code ");

 		    $passq=$bdd->prepare("UPDATE $table set pass=? where codeEtudiant=?");
 		    $passq->execute(array($_POST['pass'],$code));

 		    // on cherche dans le 1 ere zone //
 		    $query=$bdd->prepare("SELECT stagiaire1 from $binome where stagiaire1=?");
 		    $query->execute(array($code));
 		    $stagiaires1=$query->fetch();

 		    if(empty($stagiaires1)){ // si le stagiaire 1 est inscrit first cette condition se remplit

 		    	$query=$bdd->prepare("SELECT stagiaire2 from $binome where stagiaire2=? ");
 		    	$query->execute(array($code));
 		    	$stagiaire2=$query->fetch();

 		    	if(empty($stagiaire2)){

	 		    	$insertion=$bdd->prepare("INSERT INTO $binome(stagiaire1,etat) VALUES (?,0) ");
	 		    	$insertion->execute(array($code)); 
		 		    $_SESSION['zone']=2;
		 		    $_SESSION['stagiaire1']=$code;
		 		    $_SESSION['table']=$table;
				 	$_SESSION['table_bin'] = $binome;
				 	$_SESSION['niveau'] = $niveau;
				 	$_SESSION['formation'] = $ligne['formation'];	
				 	$_SESSION['prenom'] = $ligne['prenom'];	 		    
		 		    header('location:binome-selection.php');
 		    	}else{



	 		    	$query=$bdd->prepare("SELECT stagiaire1 from $binome where stagiaire2=? ");
	 		    	$query->execute(array($code));
	 		    	$stagiaire1=$query->fetch(); 	

	 		    	$_SESSION['stagiaire1']=$code; // code du stagiaire qui est connectè
	 		    	
	 		    	$_SESSION['table']=$table;
			 		$_SESSION['table_bin'] = $binome;
				 	$_SESSION['niveau'] = $niveau;
				 	$_SESSION['formation'] = $ligne['formation'];	
				 	$_SESSION['code'] = $ligne['codeEtudiant'];
				 	$_SESSION['prenom'] = $ligne['prenom'];
	 		    	$_SESSION['stagiaire']=$stagiaire1['stagiaire1'];
	 		    	$_SESSION['zone']=1; // je me suis posé le 2 donc le stagiaire1 à vérifier
	 		    	header('location:binome-selection.php');
 		    	}

 		    }else{
	 		    	$query=$bdd->prepare("SELECT stagiaire2 from $binome where stagiaire1=? ");
	 		    	$query->execute(array($code));
	 		    	$stagiaire2=$query->fetch();

	 		    	if(empty($stagiaire2['stagiaire2'])){
	 		    		$_SESSION['zone']=2;
	 		    		$_SESSION['stagiaire1']=$code;
			 		    $_SESSION['table']=$table;
				 		$_SESSION['table_bin'] = $binome;
				 		$_SESSION['niveau'] = $niveau;
				 		$_SESSION['formation'] = $ligne['formation']; 
				 		$_SESSION['prenom'] = $ligne['prenom'];		    		 
	 		    		header('location:binome-selection.php');
	 		    	}
	 		    	else { // vérification si les deux binôme ont remplis déjà les champs nom_B et mot de pass
	 		    			// stagiaire 1 exist et stagiaire 2 exit et etat = 0
			 		    $_SESSION['table'] = $table;
			 		    $_SESSION['table_bin'] = $binome;
			 		    $_SESSION['niveau'] = $niveau;
			 		    $_SESSION['formation'] = $ligne['formation'];
			 		    $_SESSION['prenom'] = $ligne['prenom'];
			 		    $_SESSION['code'] = $ligne['codeEtudiant'];
			 		    header('location:validation-binomes.php');		    		
	 		    	}
 		    }
 		//}
    //}
	}
?>
