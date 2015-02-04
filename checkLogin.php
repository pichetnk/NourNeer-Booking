<?php
session_start();
include 'config.php';
header('Content-Type: application/json');
if (isset($_POST["username"]) && $_POST["username"] != "") {
	$username = $_POST["username"];
	$password = $_POST["password"];
	$sql = "Select * From tbl_user WHERE user=:user";
	$qry = $conn->prepare($sql);
	$qry -> bindParam(':user', $username, PDO::PARAM_INT);
	if($qry -> execute()) {
		$data=array();
		$row = $qry->fetchAll();
		if($qry->rowCount()) {
				$dataUser=$row[0];
				if($dataUser['password']==sha1("EN-kku".$password."@NN27"))  {
					$_SESSION["session_id"] = session_id();
					$_SESSION["permission"] = $dataUser['permission'];
					$_SESSION["user"] = $dataUser['user'];
					$_SESSION["user_id"] = $dataUser['id'];
					echo json_encode(array('login'=>TRUE,'permission'=>$dataUser['permission']));
				}
				else {
					echo json_encode(array('login'=>FALSE,'error'=>'username or password incorrect'));
				}

		}
		else {
			echo json_encode(array('login'=>FALSE,'error'=>'username or password incorrect'));
		}
	}
	else {
		echo json_encode(array('login'=>FALSE,'error'=>'SQL','sql'=>$qry->errorInfo()));

	}

}
?>
