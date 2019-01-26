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
    if(strcmp($_POST['level'], '1A')==0){
    	$table_choix='Binomes1a_choix';
    	$binomes='Binomes1a';
    }else if(strcmp($_POST['level'], '2A')==0){
    	$table_choix='Binomes2a_choix';
    	$binomes='Binomes2a';
    }else header('location:default.php');

    $query=$bdd->query("SELECT distinct formation from $binomes");
    $ligne=$query->fetch();

    if(empty($ligne)) header('location:empty.php');
    $filiere=array(); $i=0;
    //--On vérifie la condition nombre stages >= nombre des binômes
    $stages=$bdd->prepare('SELECT COUNT(idstage) as nombre_s from stages where formation= ?');
    $stages->execute(array($ligne['formation']));
    $nombre_s=$stages->fetch();

    $bin_list=$bdd->prepare("SELECT COUNT(id_binome) as nombre_b from $binomes where formation = ? ");
    $bin_list->execute(array($ligne['formation']));
    $nombre_b=$bin_list->fetch();

    if( intval($nombre_s['nombre_s']) < intval($nombre_b['nombre_b']) ){
    	$filiere[$i]=$ligne['formation'];
    	$i=$i+1;
    }

    while ($ligne=$query->fetch()) {

	    $stages=$bdd->prepare('SELECT COUNT(idstage) as nombre_s from stages where formation= ?');
	    $stages->execute(array($ligne['formation']));
	    $nombre_s=$stages->fetch();

	    $bin_list=$bdd->prepare("SELECT COUNT(id_binome) as nombre_b from $binomes where formation = ? ");
	    $bin_list->execute(array($ligne['formation']));
	    $nombre_b=$bin_list->fetch();

	    if(intval($nombre_s['nombre_s'] ) < intval($nombre_b['nombre_b'] ) ){
	    	 $filiere[$i]=$ligne['formation'];
	    	 $i=$i+1;
	    }   
    }
    if($i!=0){
        $_SESSION['filiere']=$filiere;
         header('location:stage-nsuff.php');
    }else header('location:algorithme.php?level='.$_POST['level'].' ');
?>