<?php
	session_start();
	if(!isset($_SESSION['connexion'])) header('location:Deconnexion.php');
	$_SESSION['vue']=1;

	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
	}catch(Exception $e)
	{
	    echo 'Error : '.$e.getmessage();
	}

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

 	class Binomes{
 		public $buffer;
 		function __construct($nom1,$prenom1,$nom2,$prenom2)
 		{	
 			if(strcmp($nom1, 'rong')!=0) $this->buffer=$nom1.' '.$prenom1.'</br>'.$nom2.'-'.$prenom2;
 			else $this->buffer="Pas encore" ;
 		}
 		public function showB(){
 			echo $this->buffer.'</br>' ;
 		}
 	}

	if(strcmp($_SESSION['niveau'] , '1A')==0){
	 	$table='binomes1a';
	 	$table_choix='binomes1a_choix';
	 	$table_etud='etudiants1a';
	}else{
	 	$table='binomes2a';
	 	$table_choix='binomes2a_choix';
	 	$table_etud='etudiants2a';
	}
	
	 $table=$_SESSION['table'];
	 $formation_query=$bdd->query("SELECT DISTINCT formation from $table");

	$etudiants=$bdd->prepare("SELECT * FROM $table where formation=? ");
	$etudiants->execute(array($_POST['formation']));



?>
<!DOCTYPE html>
<html>
	<head>
		<title>AGS-resultat</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">

	</head>

	<body>

		<div class="container">
				<div class="row">
					<nav class="navbar navbar-inverse col-md-12 col-sm-12">
						<ul class="nav navbar-nav">
							<li><a href="Accueil.html">AGS</a></li>
							<li><a href="imports-selection.php">Accueil</a></li>						
						</ul> 
						<a href="Deconnexion.php" class="pull-right" style="margin-top:12px;">Deconnexion</a>
					</nav>
				 </div>
				 <header class="page-header row col-md-12 col-sm-12" style="margin-top: 10px;">
				 	<div class="jumbotron" style="padding:0.5em;">
				 		<h1>AGS</h1>
				 		<h5><p style="color:red" >Espace Administrative</p></h5>
				 	</div>
				 	<h3><p style="margin-top:-10px; font-family: 'Comic Sans MS',Arial, Verdana, sans-serif; " >Ecole Nationale Supérieure d’Informatique et d’Analyse des Systèmes, <strong style="color:red;"> ENSIAS </strong> </p></h3>
				 </header>
				 <section class="row">
				 	<div class="col-md-4 col-lg-4 col-sm-12">
				 		<h4>Note:</h4>
				 		<blockquote>
				 			<p>Tapez ici pour une autre filière:</br>
				 			<button class="btn btn-info pull-right" onclick="document.location.href='resultat-formation.php'">Back</button>
				 			</p>
				 		</blockquote>
				 	</div>
				 	<div class="col-md-8 col-lg-8 col-sm-12 ">
				 	<header>
				 		<h3 style="color:red;" >Rèsultats D'affectation</h3>
				 	</header>
					    <table class="table table-bordered table-striped table-condensed" style="margin-top:-125px;">
					    	<caption>Formation -<?php echo $_POST['formation']?> </caption>
					    		<head>
					    			<tr>
					    				<th>Equipe</th>			    						
					    				<th>Satisfaction</th>
					    				<th>Stage</th>
					    				<th>Satisfaction</th>
					    				<th>Etat</th>
					    			</tr>
					    		</head>
			    			<?php while($ligne=$etudiants->fetch()){ 
			    					
			    					if(!empty($ligne['affectation'])){

			    						$stage=$bdd->prepare("SELECT * from stages where idstage=?");
			    						$stage->execute(array($ligne['affectation']));
			    						$data=$stage->fetch();

			    						$stage=$data['titre'];
			    						$stage_stf=$data['satisfaction'];

			    						$bin_stf=$ligne['satisfaction'];

								 		$query1=$bdd->prepare("SELECT * FROM $table_etud where codeEtudiant=? ");
								 		$query1->execute(array($ligne['stagiaire1']));
								 		$ligne2=$query1->fetch();

								 		$query1=$bdd->prepare("SELECT * FROM $table_etud where codeEtudiant=? ");
								 		$query1->execute(array($ligne['stagiaire2']));
								 		$ligne3=$query1->fetch();

								 		$buffer=$ligne2['nom'].'-'.$ligne2['prenom'].'</br>'.$ligne3['nom'].'-'.$ligne3['prenom'];
								 		$indicateur='encore';	
								 		$choix_faite= 'Affectè' ;	

			    					}else{

			    						$stage='---';
			    						$stage_stf=-1;
			    						$bin_stf=-1;

								 		$query1=$bdd->prepare("SELECT * FROM $table_etud where codeEtudiant=? ");
								 		$query1->execute(array($ligne['stagiaire1']));
								 		$ligne2=$query1->fetch();

								 		$query1=$bdd->prepare("SELECT * FROM $table_etud where codeEtudiant=? ");
								 		$query1->execute(array($ligne['stagiaire2']));
								 		$ligne3=$query1->fetch();

								 		$buffer=$ligne2['nom'].'-'.$ligne2['prenom'].'</br>'.$ligne3['nom'].'-'.$ligne3['prenom'];			    

								 		$choix_test=$bdd->prepare("SELECT * from $table_choix where idb=? ");
								 		$choix_test->execute(array($ligne['id_binome']));
								 		$choix_test=$choix_test->fetch();
								 		if(empty( $choix_test['idb'] )) $choix_faite= 'Choix ratè' ;
								 		else $choix_faite= 'Pas encore' ;
								 		$indicateur='pas encore';
			    					}
			    				

			    				?>
			    				<tbody>
			    					<?php 
			    							
												echo "<tr class='active' >";
													if(strcmp($indicateur, 'pas encore')==0 ){
															echo "<td style='color:red;' >".$buffer."</td>";
															echo "<td style='color:red;' >".$bin_stf."</td>";
															echo "<td style='color:red;' >---</td>";					
															echo "<td style='color:red;' >".$stage_stf."</td>";
															echo "<td style='color:red;' >".$choix_faite."</td>";
													}else{
															echo "<td >".$buffer."</td>";
															echo "<td >".$bin_stf."</td>";
															echo "<td >".$stage."</td>";					
															echo "<td >".$stage_stf."</td>";
															echo "<td >".$choix_faite."</td>";
													}
												echo "</tr>";
			    					?>
			    				</tbody>
			    			
			    		<?php 
			    			echo '</br>'; 	
			    		} ?>
			    		</table>

			    		<?php 
							$stfemp=$bdd->prepare('SELECT AVG(satisfaction) as moy from stages where niveau=? and formation=? ');
							$stfemp->execute(array($_SESSION['niveau'],$_POST['formation']));
							$stfemp=$stfemp->fetch();

							$stfstg=$bdd->prepare("SELECT AVG(satisfaction) as moy from $table where formation=? ");
							$stfstg->execute(array($_POST['formation']));
							$stfstg=$stfstg->fetch();

			    			
			    		?>
			    					
			    		<h4><span class="label label-default">Moyenne Satisfaction des Professeurs: <?php echo $stfemp['moy'] ?></span></h4>			 
			    		<h4><span class="label label-default">Moyenne Satisfaction des Stagiaires: <?php echo $stfstg['moy'] ?></span></h4>

			    		</br>
			    		<blockquote>
			    			<p class="jumbotron" style="padding:1em;" >Les stagiaires peuvent parfois avoir un bas niveau de satisfaction,car certain d'eux n'ont pas pris la recommandations en compte,on est pûrement pas responsable</p>
			    			<small class="pull-right">Founders</small>
			    		</blockquote>
				 	</div>
				</section>

				<footer >

				</footer>
		</div>

	</body>

</html>