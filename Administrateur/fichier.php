<?php
	session_start();
	if(!isset($_SESSION['connexion'])) header('location:Deconnexion.php');
	
	if($_FILES['notes-Etudiants']['error']==0 AND $_FILES['infos-Etudiants']['error']==0 )
	{
		if($_FILES['notes-Etudiants']['size'] <= 1000000 and $_FILES['infos-Etudiants']['size'] <= 1000000 )
		{
			$info_fichier=pathinfo($_FILES['notes-Etudiants']['name']);
			$extension=$info_fichier['extension'];
			$info_fichier2=pathinfo($_FILES['infos-Etudiants']['name']);
			$extension2=$info_fichier2['extension'];

			if(strcmp($extension2, "xlsx")!=0 or strcmp($extension, "xlsx")!=0 OR !isset($_POST['niveau'])) header('location:admin.php');
			//move_uploaded_file($_FILES['Etudiants']['name'], destination)
			move_uploaded_file($_FILES['notes-Etudiants']['tmp_name'], 'uploads/'.basename($_FILES['notes-Etudiants']['name']));
			$fichier=$_FILES['notes-Etudiants']['name'];
			
			if(strcmp($_POST['niveau'], '1A')==0){
				 $table='import1A';
				 $table1='etudiants1a';
			}
			else if(strcmp($_POST['niveau'], '2A')==0){
				 $table='import2A';
				 $table1='etudiants2a';
			}
			else header('location:admin.php'); 
		     try
		     {
				$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
		     }catch(Exception $e)
		     {
		     	echo 'Error : '.$e.getmessage();
		     }
		     $bdd->exec("DELETE FROM $table");
		     $bdd->exec("DELETE FROM $table1");
			//---------------------------------------------------------------------------------------------------------------

			include 'PHPExcel/Classes/PHPExcel/IOFactory.php';

			$inputFileName = 'uploads/'.$_FILES['notes-Etudiants']['name'];
			 
			try 
			{

			    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
			    $objPHPExcel = $objReader->load($inputFileName);

			} catch (Exception $e) {

			    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
			    . '": ' . $e->getMessage());

			}
			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			 $data=array();
			//  Loop through each row of the worksheet in turn
			for ($row = 1; $row <= $highestRow; $row++) {
				$indice=0;
			    //  Read a row of data into an array
			    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
			    foreach($rowData[0] as $k=>$v)
			    {
			    	 //echo "Row: ".$row."- Col: ".($k+1)." = ".$v."<br />"; // variable $v contient 1 ligne du fichier excel
			    	 $data[$indice]=$v;
			    	 $indice++;
			    }

			    $bdd->query("INSERT INTO $table (codeEtudiant,M1,M2,M3,M4,M5,M6,M7,M8) VALUES ($data[0],$data[1],$data[2],$data[3],$data[4] ,   $data[5],$data[6],$data[7],$data[8]) ");
			}
			echo "MARKS-STOCKED";
			//---------------------------------------------------------------------------------------------------------------
			//header('location:admin.php');

			move_uploaded_file($_FILES['infos-Etudiants']['tmp_name'], 'uploads/'.basename($_FILES['infos-Etudiants']['name']));
			$fichier1=$_FILES['infos-Etudiants']['name'];

			$inputFileName = 'uploads/'.$_FILES['infos-Etudiants']['name'];
			 
			try 
			{

			    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
			    $objPHPExcel = $objReader->load($inputFileName);

			} catch (Exception $e) {

			    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
			    . '": ' . $e->getMessage());

			}
			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			 $data=array();
			//  Loop through each row of the worksheet in turn
			for ($row = 1; $row <= $highestRow; $row++) {
				$indice=0;
			    //  Read a row of data into an array
			    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
			    foreach($rowData[0] as $k=>$v)
			    {
			    	 //echo "Row: ".$row."- Col: ".($k+1)." = ".$v."<br />"; // variable $v contient 1 ligne du fichier excel
			    	 $data[$indice]=$v;
			    	 $indice++;
			    }
			$query=$bdd->prepare("INSERT INTO $table1 (codeEtudiant,prenom,nom,formation,email,confirmation) VALUES (?,?,?,?,?,?) ");
			$query->execute(array($data[0],$data[1],$data[2],$data[3],$data[4],0));
			}

			echo "INFO STOCKED";

			//---stockage des formations disponibles en se basant sur ceux des candidats---//
			
			$query=$bdd->query("SELECT DISTINCT formation from $table1");

			while($ligne=$query->fetch()){
				$query1=$bdd->prepare('INSERT INTO formation (nom) values (?) ');
				$query1->execute(array($ligne['formation']));
			}

			header('location:profil.php');
		}
	}
?>