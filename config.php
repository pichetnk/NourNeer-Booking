<?php
	$openBookingRound=array(1,2,3,4,5,6,7,8);
	$db_host="127.0.0.1";
	$db_name="nourneer";
	$db_user="webadmin";
	$db_pw="Techno48";
	try {
		$conn = new PDO('mysql:host='.$db_host.'; dbname='.$db_name, $db_user, $db_pw);
 		$conn->exec("SET CHARACTER SET utf8");
	}
	catch (PDOException $e)
  {
			 echo 'Connection failed: ' . $e->getMessage();
    	exit(0);
  }

?>
