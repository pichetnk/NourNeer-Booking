<?php
include 'config.php';

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['premission']))
{
  $sql="INSERT INTO tbl_user (user,password,permission) VALUES (:username, :password, :premiss);";
  $qry = $conn->prepare($sql);
  $qry -> bindParam(':username', $_POST['username'], PDO::PARAM_STR);
  $qry -> bindParam(':password',sha1("EN-kku"+$_POST['password']+"@NN27"), PDO::PARAM_STR);
  $qry -> bindParam(':premiss', $_POST['premission'], PDO::PARAM_STR);
  if($qry -> execute()){
    echo "save";
  }else {
    var_dump($qry ->errorInfo());
  }
}
else {
  echo "Can not Input (username,password,premission)";
}


?>
