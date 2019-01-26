<?php
	session_start();
	if(!isset($_SESSION['connexion'])) header('location:Deconnexion.php');
	
	if($_FILES['infos-profs']['error']==0)
	{
		if($_FILES['infos-profs']['size'] <= 1000000)
		{
			$info_fichier=pathinfo($_FILES['infos-profs']['name']);
			$extension=$info_fichier['extension'];

			if(strcmp($extension, "xlsx")!=0) header('location:profil.php');
			//move_uploaded_file($_FILES['Etudiants']['name'], destination)
			move_uploaded_file($_FILES['infos-profs']['tmp_name'], 'uploads/'.basename($_FILES['infos-profs']['name']));
			$fichier=$_FILES['infos-profs']['name'];	 
		}
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=AGS', 'root', '',	array(	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION	)	);
		}catch(Exception $e){
		    echo 'Error : '.$e.getmessage();
		}	
		$bdd->exec('DELETE from employeurs');
			//---------------------------------------------------------------------------------------------------------------

			include 'PHPExcel/Classes/PHPExcel/IOFactory.php';

			$inputFileName = 'uploads/'.$_FILES['infos-profs']['name'];
			 
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

			    $bdd->query("INSERT INTO employeurs (nom,prenom,email,pass,confirmation) VALUES ($data[0],$data[1],$data[2],'null',0) ");
			}
			echo "DATA-STOCKED";
			header('location:stocked.php');
	}		
?>