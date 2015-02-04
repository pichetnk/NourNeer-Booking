<?php
include 'config.php';

if(isset($_GET['r'])){

  $sql = "Select * From tbl_booking WHERE time_id= :timeid";
  $qry = $conn->prepare($sql);
  $qry -> bindParam(':timeid', $_GET['r'], PDO::PARAM_INT);
  if($qry -> execute()){
    $data=array();
    while($row = $qry->fetch()){
        array_push($data,array('seat_row'=>$row['seat_row'],'seat_colum'=>$row['seat_colum'],'status'=>$row['status']));
    }
    echo json_encode(array('status'=>'OK','data'=>$data));
  }else {
    echo json_encode(array('status'=>'ERROR','message'=>$qry->errorInfo()));

  }

}
else {
  echo json_encode(array('status'=>'ERROR','message'=>'Can not input round'));

}


?>
