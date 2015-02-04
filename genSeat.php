<?php
include 'config.php';

$seatHide=array(
      'B'=>array(13,14,15,16,17,18),
      'E'=>array(1,30),
      'F'=>array(1,30),
      'M'=>array(1,2,3,28,29,30),
      'N'=>array(1,2,3,28,29,30),
      'O'=>array(1,2,3,28,29,30)
  );


  foreach(range(1,8) as $round) {
  foreach (range('O', 'B') as $row){

      foreach (range(30,1) as $column){
        $sql="INSERT INTO tbl_booking (time_id,seat_row,seat_column,status) VALUES (:timeid,:seatRow,:seatColumn,:status)";
        $qry = $conn->prepare($sql);
        $qry -> bindValue(':timeid', $round, PDO::PARAM_INT);
        $qry -> bindParam(':seatRow', $row, PDO::PARAM_STR);
        $qry -> bindParam(':seatColumn', $column, PDO::PARAM_STR);
        $qry -> bindValue(':status', "0", PDO::PARAM_STR);
        if($qry -> execute()){
          echo "save".$round.":".$row.":".$column;
        }else {
          var_dump($qry ->errorInfo());
        }

      }
    }

  }

?>
