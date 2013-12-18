<?php 
require_once("config.php");
require_once("session.php");


if($session->checkSession() && $session->isAdmin()){
	$smarty->assign('session',$_SESSION);
	
	if(isset($_GET['eid'])){
		$smarty->assign('election_id',$_GET['eid']);
	}else{
		header("Location: ./dashboard.php");
	}
	
	$smarty->assign('election',$database->lookupElectionWithId($_GET['eid']));
	
	if(isset($_POST['submit'])){
	
		if($_FILES['file']['type'] == "text/csv"){
			if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE) {
				$array = array();
				$row = 1;
				while (($data = fgetcsv($handle)) !== FALSE) {
					if(count($data) == 2){
						if($row++ == 1){
							if($data[0] != "questionText" || $data[1] != "category"){
								$message = "File format error. Wrong Headings";
								break;
							}
						}else{
							array_push($array, $data);
						}
					}else{
						$message = "File format error. Too many Columns";
						break;
					}
				}
				if(!isset($message)){
					$smarty->assign('questions',$array);
					$smarty->display("viewcsvquestions.tpl");
					exit;
				}
			}else{
				$message = "Cannot read uploaded file";
			}
		}else {
			$message = "Only CSV files can be uploaded";
		}
	}elseif (isset($_POST['cvstodatabase'])) {
		for($i = 1; $i < count($_POST); $i++){
			$database->addQuestion($_POST[$i][0], $_POST[$i][1], $_GET['eid']);
		}		
		header("Location: ./electionprofiler.php?id=".$_GET['eid']);
		exit;
	}
	
	
	if(!empty($message)){
		$smarty->assign('message',$message);
	}
	
	$smarty->display('upload.tpl');
} else{ 
	echo "Go Away Now!";
}

?>
