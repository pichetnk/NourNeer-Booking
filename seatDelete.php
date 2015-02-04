<?php
session_start();
include 'config.php';
if(isset($_POST['id']) && isset($_POST['round'])) {

  $data= explode("_", $_POST['id']);

  $sql = "UPDATE tbl_booking SET status= :status WHERE time_id= :timeid and seat_row = :seatRow and seat_column = :seatColumn ";
  $qry = $conn->prepare($sql);
  $qry -> bindValue(':status', "0", PDO::PARAM_STR);
  $qry -> bindValue(':timeid', $_POST['round'], PDO::PARAM_INT);
  $qry -> bindParam(':seatRow', 	$data['0'], PDO::PARAM_STR);
  $qry -> bindParam(':seatColumn', 	$data['1'], PDO::PARAM_STR);
  if($qry -> execute()){
    echo "save";
  }else {
    echo "can not save";
  }

}
else {
  echo "error";
}
?>
