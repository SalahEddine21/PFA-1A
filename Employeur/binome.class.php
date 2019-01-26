<?php
 	try
 	{
 		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
 	}catch(Exception $e)
 	{
 	 	echo 'Error: '.$e.getmessage();
 	 	exit();
 	}
	 class Binomes{
	 	private $id;
	 	private $nomstg1;
	 	private $prenomstg1;
	 	private $nomstg2;
	 	private $prenomstg2;

	 	public function __construct($id,$niveau)
	 	{
	 		if(strcmp($niveau, '1A')==0) $query=$bdd->prepare('SELECT * FROM binomes1a WHERE id_binome=?');
	 		else if(strcmp($niveau, '2A')==0) $query=$bdd->prepare('SELECT * FROM binomes2a WHERE id_binome=?');
	 		$query->execute(array($id));
	 		$ligne=$query->fetch();
	 		//--
	 		$query1=$bdd->prepare('SELECT * FROM stagiaires WHERE code in (?,?)');
	 		$query1->execute(array($ligne['stagiaire1'],$ligne['stagiaire2']));
	 		//--
	 		$list=$query1->fetch();
	 		$this->nomstg1=$list['nom'];
	 		$this->prenomstg1=$list['prenom'];
	 		//--
	 		$list=$query1->fetch();
	 		$this->nomstg2=$list['nom'];
	 		$this->prenomstg2=$list['prenom'];
	 	}

	 	public function getIdb(){
	 		return $this->id;
	 	}
	 	public function getIdstg1(){
	 		return $this->stagiaire1;
	 	}
	 	public function getIdstg2(){
	 		return $this->stagiaire2;
	 	}
	 }
?>