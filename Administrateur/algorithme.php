<?php
		session_start();
		if(!isset($_SESSION['connexion'])) header('location:Deconnexion.php');

		if(strcmp( $_GET['level'] , '1A')==0){
			 $table='import1A';
			 $binome_table='binomes1a';
			 $table_choix='binomes1a_choix';
			 $_SESSION['table']=$binome_table;
			 $_SESSION['niveau']='1A';
		}
		else if(strcmp($_GET['level'] , '2A')==0){
			 $table='import2A';
			 $binome_table='binomes2a';
			 $table_choix='binomes2a_choix';
			 $_SESSION['table']=$binome_table;
			 $_SESSION['niveau']='2A';
		}
		
		//-
		class Stages
		{
			private $ligne;
			function __construct()
			{
				$this->ligne=array('idstage'=>0,'M1'=>0,'M2'=>0,'M3'=>0,'M4'=>0,'M5'=>0,'M6'=>0,'M7'=>0,'M8'=>0);
			}
			public function getLigne()
			{
				return $this->ligne;
			}
			//--
			//--
			public function getId()
			{
				return $this->ligne['idstage'];
			}
			public function getNote($key)
			{
				return $this->ligne[$key];
			}

			//--
			public function setValue($key,$val)
			{
				$this->ligne[$key]=$val;
			}
		}
		//-------------------------------------------------------------------------------------------------------//
		class Binomes
		{
			private $ligne;

			function __construct()
			{
				$this->ligne=array('id_binome'=>0,'M1'=>0,'M2'=>0,'M3'=>0,'M4'=>0,'M5'=>0,'M6'=>0,'M7'=>0,'M8'=>0);
			}
			//--
			public function getLigne()
			{
				return $this->ligne;
			}
			public function getId()
			{
				return $this->ligne['id_binome'];
			}
			public function getNote($key)
			{
				return $this->ligne[$key];
			}
			//--
			public function setValue($key,$val)
			{
				$this->ligne[$key]=$val;
			}		
			public function setId($id)
			{
				$this->ligne['id_binome']=$id;
			}	
		}
		//-----------------------------------------------------------------------------------------------//

		class Look
		{
			public $node;

			function __construct()
			{
				$this->node=array('idb'=>0,'Note'=>0);
			}

		}

		//-----------------------------------------------------------------------------------------------//

		class Stgpreference 
		{
			private $ligne;

			function __construct()
			{
				$this->ligne=array();
			}

			public function getOrdre($stage_detail,$Binomes)
			{
				
				for($i=0;$i<sizeof($Binomes);$i++)
				{
					$s=0;

					$resume[$i] = new Look();
					$resume[$i]->node['idb'] = $Binomes[$i]->getId();
					

					foreach ($Binomes[$i]->getLigne() as $key => $value) {

						if(strcmp($key, 'id_binome')!=0) 
						{
							$s = $s + $Binomes[$i]->getNote($key)*$stage_detail->getNote($key);
						}
					}
					$resume[$i]->node['Note'] = $s; 

				}

				$vide = new Look();

				for($j=0;$j<$i-1;$j++)
				{
					for($k=$j+1;$k<$i;$k++)
					{
						if($resume[$j]->node['Note'] < $resume[$k]->node['Note'])
						{
							
							$vide->node['idb'] = $resume[$k]->node['idb'];
							$vide->node['Note'] = $resume[$k]->node['Note'];

							$resume[$k]->node['idb'] = $resume[$j]->node['idb'];
							$resume[$k]->node['Note'] = $resume[$j]->node['Note'];

							$resume[$j]->node['idb'] = $vide->node['idb'];
							$resume[$j]->node['Note'] = $vide->node['Note'];
						}
					}
				}

				$this->ligne[0]=$stage_detail->getId();

				for($j=0;$j<$i;$j++) $this->ligne[$j+1]=$resume[$j]->node['idb'];				

			}

			public function getLigne()
			{
				return $this->ligne;
			}

			public function showLigne()
			{		
				echo $this->ligne[0].'</br>';
				for($i=1;$i<sizeof($this->ligne);$i++) echo $this->ligne[$i].' ';
					echo '</br>-----------------------------------</br>';
			}
		}
		//-----------------------------------------------------------------------------------------------//

		class Choix
		{
			public $node;

			function __construct()
			{
				$this->node=array('Choix'=>0,'Note'=>0);
			}

		}

		//**************************************************************************//
		function getStageById($id,$tab_stages)
		{
			for($i=0;$i<sizeof($tab_stages);$i++)
			{
				if(strcmp($tab_stages[$i]->getId() , $id)==0) return $tab_stages[$i]->getLigne();
			}
		}
		function getBinomeById($id,$Binomes)
		{
			for($i=0;$i<sizeof($Binomes);$i++)
			{
				if(strcmp($Binomes[$i]->getId(), $id)==0) return $Binomes[$i]->getLigne();
			}
		}

		function getMarke($binome,$stage)
		{
			$s=0;
			foreach ($binome as $key => $value) {
				if(strcmp($key, 'id_binome')!=0)
				{
					$s=$s+ $binome[$key]*$stage[$key] ;
				}
			}
			return $s;
		}

		//**************************************************************************//

		class Binpreference
		{
			public $id;
			public $ligne;
			public $nombre_choix=0;

			function __construct()
			{

			}

			public function set_Pre_N($listchoix,$Binomes,$tab_stages)
			{
				$indice=0;

				for($i=1;$i<=5;$i++){
					if($listchoix[$i]!=0){
						  $this->ligne[$indice] = new Choix();
						  $indice++;
					} 
				}
				$this->id = $listchoix['idb'];
				
				$binome = getBinomeById($listchoix['idb'],$Binomes); // id du binome dans l'entre i

				for($i=1;$i<=5;$i++) { // on stop quant on parcours tous les choix de chaque binomes

					if($listchoix[$i]!=0){
					
					$this->ligne[$i-1]->node['Choix']=$listchoix[$i]; // extraction de l'ID du stage i

					$stage = getStageById($listchoix[$i],$tab_stages); // extraction des prerequis du stage i

					$this->ligne[$i-1]->node['Note']=getMarke($binome,$stage); // calcul de la note du binome dans ce stage i

					}
				}

				$this->nombre_choix=$indice-1;

			}

			public function getLigne()
			{
				return $this->ligne;
			}
			public function getId()
			{
				return $this->id;
			}
			public function getNode($key)
			{
				return $this->ligne[$key];
			}

			public function getNumberChoices()
			{
				return $this->nombre_choix;
			}

			public function getNodep($key)
			{
				return $this->ligne[$key]->node;
			}
			public function getNote($stg)
			{
				if($stg==-1) return -1;
				for($i=0;$i<=$this->nombre_choix;$i++)
				{
					if($this->ligne[$i]->node['Choix'] == $stg) return $this->ligne[$i]->node['Note'];
				}				
			}
			public function nextOne($stgactuel)
			{
				for($i=0;$i<=$this->nombre_choix;$i++)
				{
					if($this->ligne[$i]->node['Choix']==$stgactuel){
						$indstg=$this->indicestage($stgactuel); // le nombre de selection du stage
						if($indstg == ($this->nombre_choix+1) ) return -1; // si le binôme a consommè tous les stages de ça list et aucun d'eux ne l'a acceptè
						return $this->ligne[$i+1]->node['Choix'];
					}
				}
			}
			public function indicestage($stg)
			{
				for($i=0;$i<=$this->nombre_choix;$i++)
				{ 
					if($this->ligne[$i]->node['Choix']==$stg) return $i+1;
				}				
			}
			//--
			public function setId($id)
			{
				$this->id=$id;
			}

			public function setLigne($ligne)
			{
				$this->ligne=$ligne;
			}
			public function setLigneByValue($entre)
			{
				$i=0;

				for($i=0;$i<=$this->nombre_choix;$i++)
				{
					$this->ligne[$i]->node['Choix']=$entre[$i]->node['Choix'];
					$this->ligne[$i]->node['Note']=$entre[$i]->node['Note'];
				}
			}
			public function setNote($stg,$note)
			{
				for($i=0;$i<=$this->nombre_choix;$i++)
				{
					if($this->ligne[$i]->node['Choix']==$stg) $this->ligne[$i]->node['Note']=$note;
				}
			}
			public function show()
			{
				echo  'Binôme: '.$this->id.'</br> ';
				for($i=0;$i<=$this->nombre_choix;$i++)
				{
					echo $this->ligne[$i]->node['Choix'].' / '.$this->ligne[$i]->node['Note'].'----' ;
				}
				echo '</br>';
			}

		}

		//-----------------------------------------------------------------------------------------------//

		//------------------------- Tableau Comportant la liste des Stages ainsi que leurs prérequis ----------------------//
	     try
	     {
			$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
	     }catch(Exception $e)
	     {
	     	echo 'Error : '.$e.getmessage();
	     }		

	     $query=$bdd->query("SELECT COUNT(idstage) as nombre FROM stages where affectation=0 and satisfaction=0");
	     $entre=$query->fetch();

	     $nombre=intval($entre['nombre']);

	     $query=$bdd->query("SELECT * FROM stages_detail where idstage in (select idstage from stages where affectation=0) ");
	     $i=0;

	     while ($entre=$query->fetch()) {

	     	$tab_stages[$i] = new Stages();

	     	foreach ($tab_stages[$i]->getLigne() as $key => $value) {
	     		$tab_stages[$i]->setValue($key,$entre[$key]);
	     	}
	     	$i++;
	     }

		 $i=0;	     

		 //------------------------- Tableau Comportant la liste des Binomes ainsi que leurs notes -----------------------//

	     $query=$bdd->query("SELECT * FROM $binome_table where affectation=0 and satisfaction=0");

	     while($entre=$query->fetch() )
	     {
	     	$test=$bdd->prepare("SELECT * FROM $table_choix WHERE idb= ?");
	     	$test->execute(array($entre['id_binome']));

	     	if(!empty($test)){ // si le binome a fait leur propre choix

		     	$notes1=$bdd->query('SELECT * FROM '.$table.' WHERE codeEtudiant=\'' .$entre['stagiaire1']. '\'');
		     	$ligne_s1=$notes1->fetch();

		     	$notes2=$bdd->query('SELECT * FROM '.$table.' WHERE codeEtudiant=\'' .$entre['stagiaire2']. '\'');
		     	$ligne_s2=$notes2->fetch();

		     	$Binomes[$i] = new Binomes();

		     	$Binomes[$i]->setId($entre['id_binome']);

		     	foreach ($Binomes[$i]->getLigne() as $key => $value) {

		     		if(strcmp($key, 'id_binome')!=0){
		     			$moyenne=( $ligne_s1[$key]+ $ligne_s2[$key] )/2;
		     			$Binomes[$i]->setValue($key,$moyenne);
		     		}
		     	}

		     	$i++;
	     	}
	     }
 		echo "*************************************************************************************************************</br>";
	     //----- Stgpreference: tableau contient les id des stages et les binomes les plus recommondés pour chaqun d'eux ---//
	     for($u=0; $u<sizeof($tab_stages) ;$u++)
	     {
	     	$Stgpreference[$u] = new Stgpreference();
	     	$Stgpreference[$u]->getOrdre($tab_stages[$u],$Binomes);
	     	//$Stgpreference[$u]->showLigne();
	     } 
	     echo "*************************************************************************************************************</br>";
	     //---------------Tableau des preferences du stagiaire idstage-note.. ------------------//

	    echo "----------------------------------------------------------------------------------------------------------------</br>";
	    echo '********************** Tableau des préférences des binômes **************************</br>';
	    echo "----------------------------------------------------------------------------------------------------------------</br>";


	     
	    // echo 'Le nombre des choix existant: '.$bound.'';

	     //$Binpreference[2]->setNote(7,16.96);	 //pour vérifié la condition si deux binôme ont la même note dans 1 stage (dbr choix) //

	     function tri_ligne($ligne,$bound)
	     {

	     	for($i=0 ;$i<=$bound-1; $i++)
	     	{
	     		for($j=$i+1; $j<=$bound; $j++)
	     		{
	     			if($ligne[$i]->node['Note'] < $ligne[$j]->node['Note'])
	     			{

	     				$zone->node['Note']=$ligne[$i]->node['Note'];
	     				$zone->node['Choix']=$ligne[$i]->node['Choix'];

	     				$ligne[$i]->node['Note']=$ligne[$j]->node['Note'];
	     				$ligne[$i]->node['Choix']=$ligne[$j]->node['Choix'];

	     				$ligne[$j]->node['Note']=$zone->node['Note'];
	     				$ligne[$j]->node['Choix']=$zone->node['Choix'];

	     			}
	     		}
	     	}
	     	return $ligne;
	     }
	    echo "----------------------------------------------------------------------------------------------------------------</br>";
	    echo '********************** Tableau des préférences triès selon les notes des binômes **************************</br>';
	    echo "----------------------------------------------------------------------------------------------------------------</br>";
	    function getArray($Binpreference,$bound)
	    {
	    	for($i=0;$i<sizeof($Binpreference);$i++)
	    	{
	    		$bin[$i] = new Binpreference();
	    		$bin[$i]->nombre_choix=$bound;
	    		$bin[$i]->setId($Binpreference[$i]->getId());

	    		$bin[$i]->setLigneByValue($Binpreference[$i]->getLigne()); 
	    		$bin[$i]->setLigne(tri_ligne($bin[$i]->getLigne(),$bound));
	    	}
	    	return $bin;
	    }

	     $zone=new Choix();
	    class Affectation
	    {
	    	private $idstage;
	    	private $idbinome;
	    	private $notebinome;
	    	private $stfstg;
	    	private $stfemp;

	    	public function __construct($ids,$idb,$note)
	    	{
	    		$this->idstage=$ids;
	    		$this->idbinome=$idb;
	    		$this->notebinome=$note;
	    	}

	    	public function getIdstage()
	    	{
	    		return $this->idstage;
	    	}
	    	public function getIdb()
	    	{
	    		return $this->idbinome;
	    	}
	    	public function getNoteB()
	    	{
	    		return $this->notebinome;   
	    	}
	    	public function getStfstg()
	    	{
	    		return $this->stfstg;
	    	}
	    	public function getStfemp()
	    	{
	    		return $this->stfemp;
	    	}
	    	//--
	    	public function setIdstage($ids)
	    	{
	    		$this->idstage=$ids;
	    	}
	    	public function setIdb($idb)
	    	{
	    		$this->idbinome=$idb;
	    	}
	    	public function setStfstg($stg)
	    	{
	    		$this->stfstg=$stg;
	    	}
	    	public function setStfemp($emp)
	    	{
	    		$this->stfemp=$emp;
	    	}
	    	public function setNote($note)
	    	{
	    		$this->notebinome=$note;
	    	}
	    	public function show()
	    	{
	    		echo $this->idbinome.' -> '.$this->idstage.' </br>' ;
	    	}
	    }

	    class Desc
	    {
	    	public $node;

	    	public function __construct()
	    	{
	    		$this->node=array('idb','Indice');
	    	}
	    }
   		echo "----------------------------------------------------------------------------------------------------------------</br>";
   		
   		function show($tab_aff)
   		{
   			for($i=0 ;$i<sizeof($tab_aff) ;$i++)
   				$tab_aff[$i]->show();
   		}
   		// fonction retourne un tableau contenant le ou les stages qui débordent
   		 function debordant($tab_affect)
   		 {
   		 	$debordant=array();
   		 	for($i=0 ;$i<sizeof($tab_affect)-1; $i++)
   		 	{
   		 		for($j=$i+1 ;$j<sizeof($tab_affect) ;$j++)
   		 		{
   		 			if($tab_affect[$i]->getIdstage() != -1 ){
	   		 			if($tab_affect[$i]->getIdstage() == $tab_affect[$j]->getIdstage())
	   		 			{
	   		 				if(!in_array($tab_affect[$i]->getIdstage(), $debordant)) // test si le stage existe déjà dans le tableau des dbrs
	   		 				{
	   		 					$bound=sizeof($debordant);
	   		 					$debordant[$bound] = $tab_affect[$i]->getIdstage();
	   		 				}
	   		 			}
   		 			}
   		 		}
   		 	}
   		 	return $debordant;
   		 }
   		 // fonction retourne les stagiares ainsi que leurs notes dans un stages débordant
   		 function debordeur($idstage,$tab_affect)
   		 {
   		 	$k=0;
   		 	for($i=0 ;$i<sizeof($tab_affect); $i++)
   		 	{
   		 		if($tab_affect[$i]->getIdstage() == $idstage )
   		 		{
   		 			$stagiaire[$k] = new Look();
   		 			$stagiaire[$k]->node['idb'] = $tab_affect[$i]->getIdb();
   		 			$stagiaire[$k]->node['Note'] = $tab_affect[$i]->getNoteB();
   		 			$k++;
   		 		}
   		 	}
   		 	return $stagiaire;
   		 }
   		 // cette fonction retourne le stagiaire majorants
   		 function gagnant($stagiaire)
   		 {   		 	
   		 	$zone  = new Look();
   		 	$zone->node['idb'] = $stagiaire[0]->node['idb'];
   		 	$zone->node['Note'] = $stagiaire[0]->node['Note'];
   		 	for($i=1;$i<sizeof($stagiaire) ;$i++)
   		 	{
   		 		if($stagiaire[$i]->node['Note'] > $zone->node['Note'])
   		 		{
   		 			$zone->node['idb'] = $stagiaire[$i]->node['idb'];
   		 			$zone->node['Note'] = $stagiaire[$i]->node['Note'];
   		 		}
   		 	}
   		 	return $zone;
   		 }
   		 // cette fonction retourne un tableau des stagiaires qui ont la même nôte que le majorant
   		 function majorants($zone,$stagiaire)
   		 {
   		 	$tab=array(); $k=0;
   		 	for($i=0 ;$i<sizeof($stagiaire); $i++)
   		 	{
   		 		//
   		 		if( strcmp($stagiaire[$i]->node['Note'],$zone->node['Note'])==0  )
   		 		{
   		 			$tab[$k] = $stagiaire[$i]->node['idb'];
   		 			echo $tab[$k].'</br>';
   		 			$k=$k+1;
   		 		}
   		 	}
   		 	return $tab;
   		 }
   		 // cleaner effectivement groupe les stagiaires minoritaires dans un tableau ($out) , si y'a un mojorant
   		 function cleaner($premiere,$stagiaire)
   		 {
   		 	$out=array(); $k=0;
   		 	$id=$premiere->node['idb'];

   		 	for($i=0 ;$i<sizeof($stagiaire); $i++ )
   		 	{
   		 		if($stagiaire[$i]->node['idb'] != $id)
   		 		{
   		 			$out[$k] = $stagiaire[$i]->node['idb'];
   		 			$k=$k+1;
   		 		}
   		 	}
   		 	return $out;
   		 }
   		 function in_tab($num,$array)
   		 {
   		 	for($i=0;$i<sizeof($array);$i++)
   		 	{
   		 		if($array[$i]->node['idb'] == $num ) return 1;
   		 	}
   		 	return 0;
   		 }
   		// cleaner effectivement groupe les stagiaires minoritaires dans un tableau ($out) , si y'a plusieurs majorants
   		 function cleanerplus($tab_majorants,$stagiaire)
   		 {
   		 	$k=0; $out=array();
   		 	for($i=0;$i<sizeof($stagiaire);$i++)
   		 	{
   		 		if(!in_array($stagiaire[$i]->node['idb'] , $tab_majorants))
   		 		{
   		 			$out[$k]=$stagiaire[$i]->node['idb'];
   		 			$k=$k+1;
   		 		}
   		 	}
   		 	return $out;
   		 }
   		 function cleaner2($tab_reduit,$choix_tab)
   		 {
   		 	$out=array(); $k=0;
   		 	for($i=0;$i<sizeof($choix_tab);$i++)
   		 	{
   		 		if(in_tab($choix_tab[$i]->node['idb'],$tab_reduit)==0)
   		 		{
   		 			$out[$k]=$choix_tab[$i]->node['idb'];
   		 			$k=$k+1;
   		 		}
   		 	}
   		 	return $out;
   		 }
   		 // cleaner effectivement groupe les stagiaires majorants ms ceux qui ont un choix min à un stage qui déborde
   		 function cleanerplusplus($index,$choix_tab)
   		 {
   		 	$id=$index[0]->node['idb']; $out=array(); $k=0;
   		 	for($i=0;$i<sizeof($choix_tab);$i++)
   		 	{
   		 		if($choix_tab[$i]->node['idb'] != $id) 
   		 		{
   		 			$out[$k] = $choix_tab[$i]->node['idb'];
   		 			$k=$k+1;
   		 		}
   		 	}
   		 	return $out;
   		 }

   		 function cleanothers($id,$tab_reduit)
   		 {
   		 	$out=array(); $k=0;
   		 	for($i=0;$i<sizeof($tab_reduit);$i++)
   		 	{
   		 		if($tab_reduit[$i]->node['idb'] != $id)
   		 		{
   		 			$out[$k]=$tab_reduit[$i]->node['idb'];
   		 			$k=$k+1;
   		 		}
   		 	}
   		 	return $out;
   		 }

   		 // indice from affectation tableau
   		 function getIndiceFromAff($tab_aff,$idb)
   		 {
   		 	for($i=0; $i<sizeof($tab_aff) ;$i++)
   		 	{
   		 		if($tab_aff[$i]->getIdb() == $idb ) return $i;
   		 	}
   		 }
   		 //indice from tableau des preferences triè
   		 function getIndiceBin($Binpreference_tri,$idb)
   		 {
   		 	for($i=0;$i<sizeof($Binpreference_tri);$i++)
   		 	{
   		 		if($Binpreference_tri[$i]->getId() == $idb) return $i;
   		 	}
   		 }
   		 // fonction main qui prend les stagiaires minoritaires pour leur décaler vers le stages suivants (le plus recommandés pour eux)
   		 function changer($tab_aff,$out,$Binpreference_tri,$debordant)
   		 {
   		 	for($i=0 ;$i<sizeof($out) ;$i++)
   		 	{

   		 		$indF=getIndiceFromAff($tab_aff,$out[$i]);
   		 		$indB=getIndiceBin($Binpreference_tri,$out[$i]);
   		 		$nextStage=$Binpreference_tri[$indB]->nextOne($debordant);
   		 		$tab_aff[$indF]->setIdstage($nextStage);
   		 		$note=$Binpreference_tri[$indB]->getNote($nextStage);
   		 		$tab_aff[$indF]->setNote($note);

   		 	}
   		 	return $tab_aff;
   		 }
   		 // extrait les différents choix que les majorants ont faient pour un stage i (debordant)
   		 function choix($tab_majorants,$Binpreference,$debordant)
   		 {
   		 	echo 'même choix et même note:';
   		 	for($i=0; $i<sizeof($tab_majorants) ;$i++)
   		 	{
   		 		$indB = getIndiceBin($Binpreference,$tab_majorants[$i]);
   		 		$tab[$i] = new Desc();
   		 		$tab[$i]->node['idb']=$tab_majorants[$i];
   		 		$tab[$i]->node['Indice'] = $Binpreference[$indB]->indicestage($debordant);
   		 		echo $tab[$i]->node['idb'].'->'.$tab[$i]->node['Indice'].'</br>';
   		 		
   		 	}
	
   		 	return $tab;
   		 }
   		 // le première choix
   		 function choix_mn($tableau)
   		 {
   		 	$id = $tableau[0]->node['Indice'];
   		 	for($i=1;$i<sizeof($tableau);$i++)
   		 	{
   		 		if($tableau[$i]->node['Indice'] < $id) $id=$tableau[$i]->node['Indice'];
   		 	}
   		 	return $id;
   		 }
   		 // fonction qui group le tableau des majorants on un plus réduit selon les choix qu'ils ont fait à un stage (dbr)
   		 function reduire($choix_tab,$min)
   		 {
   		 	$k=0;
   		 	for($i=0; $i<sizeof($choix_tab);$i++)
   		 	{
   		 		if($choix_tab[$i]->node['Indice'] == $min)
   		 		{
   		 			$tab_r[$k] = new Desc();
   		 			$tab_r[$k]->node['idb'] = $choix_tab[$i]->node['idb'];
   		 			$tab_r[$k]->node['Indice'] = $min;
   		 			$k=$k+1;
   		 		}
   		 	}
   		 	return $tab_r;
   		 }

   		 function maxId($tab_reduit)
   		 {
   		 	$max = $tab_reduit[0]->node['idb'];
   		 	for($i=1;$i<sizeof($tab_reduit); $i++)
   		 	{
   		 		if($max < $tab_reduit[$i]->node['idb']) $max = $tab_reduit[$i]->node['idb'];
   		 	}
   		 	return $max;
   		 }

   		 function minId($tab_reduit)
   		 {
   		 	$idmin = $tab_reduit[0]->node['idb'];
   		 	for($i=1;$i<sizeof($tab_reduit); $i++)
   		 	{
   		 		if($idmin > $tab_reduit[$i]->node['idb']) $idmin = $tab_reduit[$i]->node['idb'];
   		 	}
   		 	return $idmin;
   		 }   		 


   		 //------------------------------- algorithme -------------------------------//
   		 function randId($min,$max,$tab){
   		 	do{
   		 		$id=mt_rand($min,$max);
   		 	}while(in_tab($id, $tab)==0);
   		 	return $id;
   		 }

   		function getStfEmp($note)
   		{
   			if($note>=16 && $note<=20) $stf=5;
   			else if($note>=13 && $note<16) $stf=4;
   			else if($note>=12 && $note<13) $stf=3;
   			else if($note>=10 && $note<12) $stf=2;
   			else if($note>=7 && $note<10) $stf=1;
   			else $stf=0;
   			return $stf;
   		}

   		function getStfBin($indicestg)
   		{
   			if($indicestg==1) $stf=5;
   			else if($indicestg==2) $stf=4;
   			else if($indicestg==3) $stf=3;
   			else if($indicestg==4) $stf=2;
   			else $stf=1;
   			return $stf;
   		}
   		 //--------------------------------------------------------------------------------------------------------------------//

   		 $formation_q=$bdd->query("SELECT DISTINCT formation from $binome_table where id_binome in (select distinct idb from $table_choix ) ");

   		while($formation_l=$formation_q->fetch()){
   		
   		echo "</br>________________________________________________________________________________________________________________</br>";	
   		echo "AFFECTATION DE LA FORMATION : ".$formation_l['formation'].'</br>';
   		echo "</br>________________________________________________________________________________________________________________</br>";	
  		
	    // cette requête extrait de la table des choix des binômes ceux qui appartient à la formation en cours 
	    $query=$bdd->prepare("SELECT * FROM $table_choix where affecter=0 and idb in (select id_binome from $binome_table where formation=? ) ");
	    $query->execute(array($formation_l['formation']));
	    $entre=$query->fetch();
	    // si y'a encore des binômes non affectés
	     if(!empty($entre['choix1'])){

	     	$Binpreference[0] = new Binpreference();
	     	$Binpreference[0]->set_Pre_N($entre,$Binomes,$tab_stages); // on passe les details du 1 première entre (première binome donc)
	     	$Binpreference[0]->show();
	     	$i=1;
	     while($entre=$query->fetch())
	     {
	     	$Binpreference[$i] = new Binpreference();
	     	$Binpreference[$i]->set_Pre_N($entre,$Binomes,$tab_stages); // on passe les details du 1 première entre (première binome donc)
	     	$Binpreference[$i]->show();
	     	//echo "--------------------------------";
	     	$i++;
	     }
	    echo "----------------------------------------------------------------------------------------------------------------</br>";
	    $bound=$Binpreference[0]->nombre_choix;
	    $Binpreference_tri=getArray($Binpreference,$bound);
	    for($i=0;$i<sizeof($Binpreference);$i++) echo $Binpreference_tri[$i]->show();
	    echo "----------------------------------------------------------------------------------------------------------------</br>";
	    //---- création du tableau d'affectation 1---------//
	    $binome_nombre=sizeof($Binpreference);
   		for($i=0 ;$i<$binome_nombre; $i++)
   		{
   			
   			$node=$Binpreference_tri[$i]->getNodep(0);
   			$ids = $node['Choix'];
   			$idb = $Binpreference_tri[$i]->getId();
   			$note = $node['Note'];
   			$tab_affect[$i] = new Affectation($ids,$idb,$note);
   			$tab_affect[$i]->show();
   		}

   		$tab_debordant=debordant($tab_affect); // la liste des stages qui débordent
   		while(!empty($tab_debordant)) // tant que y'a aucune stage qui déborde
   		{
   		 	echo "*************************************************************************************************************</br>";
   		
	    	for($i=0 ;$i<sizeof($tab_debordant); $i++)
	   		{
				echo "--------------------------------------------------------------------</br>";
	   		 	$stagiaire=debordeur($tab_debordant[$i],$tab_affect); // les stagiaires débordeurs
	   		 	//showm($tab_debordant[$i],$stagiaire);
	   		 	//print_r($stagiaire);
	   		 	$premiere = gagnant($stagiaire); // extraction du premiere nôte
	   		 	//echo 'MAX note: '.$premiere->node['Note'].'</br>';
	   		 	$tab_majorants = majorants($premiere,$stagiaire); // extraction des majorants 

	   		 	if(sizeof($tab_majorants)==1) // si y'a qu'un majorant
	   		 	{
	   		 		$debordant=$tab_debordant[$i];
	   		 		$out=cleaner($premiere,$stagiaire); // les autres stagiaires(minoritaires) dans le tableau $out
	   		 		$tab_affect = changer($tab_affect,$out,$Binpreference_tri,$debordant); // décalage des minoritaires vers les stages suivants

	   		 		show($tab_affect);
	   		 	}else{

					$out=cleanerplus($tab_majorants,$stagiaire); //extraction des minoritaires
					$tab_affect = changer($tab_affect,$out,$Binpreference_tri,$tab_debordant[$i]); // decalage vers les stages suivants
	   		 		//--
	   		 		$choix_tab = new Desc();
	   		 		$choix_tab = choix($tab_majorants,$Binpreference,$tab_debordant[$i]); // chaque majorant ainsi que le choix qu'il a attribuè au stage i (dbr)
	   		 		$choixmin = choix_mn($choix_tab); // le première choix qui a était fait pour le stage i
	   		 		$tab_reduit=reduire($choix_tab,$choixmin); // tableau des choix min
	   				echo "---------------------------------------------------------------</br>";
	   		 	   	show($tab_affect);

	   		 		if(sizeof($tab_reduit)==1) // si y'on a qu'un seul 
	   		 		{

	   		 			$out = cleanerplusplus($tab_reduit,$choix_tab); // extraction des binômes sui ont fait un choix supérieur
	   		 			$tab_affect = changer($tab_affect,$out,$Binpreference_tri,$tab_debordant[$i]); // et décalage vers le suivant
		   				echo "---------------------------------------------------------------</br>";
		   		 	   	show($tab_affect);
	   		 			echo "</br> Ligne: 753";

	   		 		}else{
	   		 			echo "---------------------------------------------------------------</br>";
	   		 			//-- decalage de ceux qui ont fait un choix min
	   		 			$out=cleaner2($tab_reduit,$choix_tab);
	   		 			//print_r($out);
	   		 			$tab_affect = changer($tab_affect,$out,$Binpreference_tri,$tab_debordant[$i]);  
		   		 	   	show($tab_affect);
   						echo "---------------------------------------------------------------</br>";
	   		 			//--- génération d'un id aléatoire (winner)
	   		 			$max=maxId($tab_reduit);
	   		 			$idmin=minId($tab_reduit);
	   		 			$winner=randId($idmin,$max,$tab_reduit); // un id aléatoire parmis ceux qui sont selectionnés 
	   		 			//-- les autres au stages suivants
	   		 			echo "---------------------------------------------------------------</br>";
	   		 			echo 'Winner: '.$winner.'</br>';
	   		 			$out=cleanothers($winner,$tab_reduit);// out c'est les stagiaires non affectès par l'aléatoire
	   		 			echo "---------------------------------------------------------------</br>";
	   		 			print_r($out);
	   		 			$tab_affect = changer($tab_affect,$out,$Binpreference_tri,$tab_debordant[$i]); // les outs aù suivant
	   		 			echo "---------------------------------------------------------------</br>";
		   		 	   	show($tab_affect);
	   		 			echo "</br> Ligne: 803";
	   		 		}
	   		 	}
	   		}
   		$tab_debordant=debordant($tab_affect);
   		echo print_r($tab_debordant).'</br>' ;
   		}

    for($i=0;$i<sizeof($tab_affect);$i++)
   		{
   			if($tab_affect[$i]->getNoteB()!=-1){
	   			$tab_affect[$i]->setStfemp(getStfEmp($tab_affect[$i]->getNoteB()));
	   			$indB=getIndiceBin($Binpreference,$tab_affect[$i]->getIdb());
	   			$stgaffect=$tab_affect[$i]->getIdstage();
	   			$indicestg=$Binpreference[$indB]->indicestage($stgaffect);
	   			$tab_affect[$i]->setStfstg(getStfBin($indicestg));
   			}
   		}
   		echo "</br>----------------------------------------------------------------------------------------</br>";
   		for($i=0;$i<sizeof($tab_affect);$i++)
   		{
   			if($tab_affect[$i]->getNoteB() != -1){
   			echo 'Binôme: '.$tab_affect[$i]->getIdb().' Stage: '.$tab_affect[$i]->getIdstage().' StfStg: '.$tab_affect[$i]->getStfstg();
   			echo ' Nôte: '.$tab_affect[$i]->getNoteB().' StfEmp: '.$tab_affect[$i]->getStfemp().' </br>';
   			}
   		}
   		echo "----------------------------------------------------------------------------------------</br>";
   					//---------------------enregistrement dans la base de données-------------------------------//
   					
		for($i=0;$i<sizeof($tab_affect);$i++){

	if($tab_affect[$i]->getIdstage()!=-1){ // si le stage est affectè à un binôme

	$bdd->exec(" UPDATE $binome_table SET affectation=".$tab_affect[$i]->getIdstage().",satisfaction=".$tab_affect[$i]->getStfstg()." WHERE id_binome=".$tab_affect[$i]->getIdb()." ");
		  $bdd->exec(" UPDATE stages SET affectation=".$tab_affect[$i]->getIdb().",satisfaction=".$tab_affect[$i]->getStfEmp()." WHERE 	idstage=".$tab_affect[$i]->getIdstage()." ");
		  $bdd->exec("UPDATE $table_choix set affecter=1 where idb=".$tab_affect[$i]->getIdb()." ");
	
	}else $bdd->exec("UPDATE $table_choix set affecter=0 where idb=".$tab_affect[$i]->getIdb()." "); // indice d'affectation

   		}
   		unset($tab_debordant);
   		unset($Binpreference);
   		unset($Binpreference_tri);
   		unset($tab_affect);
   		//====//
   		} // if(! all of them have been affected)
   	}

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<script>
	document.location.href='resultat-formation.php';
</script>
</body>
</html>
<?php  ?>