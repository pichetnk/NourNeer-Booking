<?php
session_start();

if(!isset($_SESSION["session_id"]) && $_SESSION["session_id"] !=session_id() ){
  header('Location:index.php');
}

include 'config.php';
$permission=$_SESSION["permission"];
$seatHide=array(
      'B'=>array(13,14,15,16,17,18),
      'E'=>array(1,30),
      'F'=>array(1,30),
      'M'=>array(1,2,3,28,29,30),
      'N'=>array(1,2,3,28,29,30),
      'O'=>array(1,2,3,28,29,30)
  );
if(!isset($_GET['round'])){
    header('Location:error.php?code=400');
}
$round=$_GET['round'];
if($permission!=0 && $round!=$permission) {
  header('Location:error.php?code=401');
}
if(!in_array($round,$openBookingRound)){
   header('Location:error.php?code=400');
}


?>

<!DOCTYPE >
<html>
  <head>
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Nourneer Booking :: BEWILDER</title>

      <!-- Bootstrap -->
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="css/style.css" rel="stylesheet">

    </head>

    <body>
      <div id="wrap">
      <div class="container-fluid">

       <div class="row">
        <div class="col-md-2 headObject">
          <div class="col-md-8">
        <select class="form-control" id="roundSelcet" >
        <?php
        if($permission!=0){
          $sql = "Select * From tbl_time WHERE id=:round";
          $qry = $conn->prepare($sql);
          $qry -> bindParam(':round', $round, PDO::PARAM_INT);
        }else {
          $sql = "Select * From tbl_time";
          $qry = $conn->prepare($sql);
        }

          if($qry -> execute()){
            $data=array();
            while($row = $qry->fetch()){
                echo "<option value=".$row['id'];
                echo ($round==$row['id']) ? ' selected ' : '';
                echo ">".$row['describe']."</option>";
            }

          }
        ?>
        </select>
      </div></div>
        <div class="col-md-8">
        <div class="page-header" style="margin-bottom:0;">
        <?php
          $sql = "Select * From tbl_time WHERE id=:round";
          $qry = $conn->prepare($sql);
          $qry -> bindParam(':round', $round, PDO::PARAM_INT);
          if($qry -> execute()){
            $data=array();
            while($row = $qry->fetch()){
              echo '<h3><p class="text-center">'.$row['detail'].'</p></h3>';
            }
          }
        ?>
      </div>
    </div>
    <div class="col-md-2 headObject">
        <a class="btn btn-default pull-right" href="logout.php" >Logout</a>
    </div>
</div>
</div>
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="stage center-block"><h1>STAGE</h1></div>
      </div>
    </div>
<?php
//get booking seat
  $sql = "Select * From tbl_booking WHERE time_id= :timeid";
  $qry = $conn->prepare($sql);
  $qry -> bindParam(':timeid', $round, PDO::PARAM_INT);
  if($qry -> execute()){
    $data=array();
	$countRow=$qry->rowCount();
	$countSeatBooked=0;
    while($row = $qry->fetch()){
		if($row['status']==1) $countSeatBooked++;
      $data[$row['seat_row']."_".$row['seat_column']]=$row['status'];

    }

  }else {
    echo json_encode(array('status'=>'ERROR','message'=>$qry->errorInfo()));
    exit(0);
  }

///print seat

$startCol=30;
foreach (range('O', 'B') as $row){
  echo '<div class="row"> <div class="col-md-6 seatRow">'."\n";
      foreach (range(30,1) as $column){
        if($column==15) echo '</div><div class="col-md-6">'."\n";
          if(isset($seatHide[$row]) &&  in_array($column,$seatHide[$row])){
              echo '<a class="seat invisible seatBooking" id="'.$row.'_'.$column.'"  href="#">'.$row.$column."</a>"."\n";
          }else {
            if($data[$row.'_'.$column]==0) {
              echo '<a class="seat seatBooking" id="'.$row.'_'.$column.'" href="#">'.$row.$column."</a>"."\n";
            }else {
              echo '<a class="seat seatbooked" id="'.$row.'_'.$column.'" href="#">'.$row.$column."</a>"."\n";
            }
          }

      }
  echo '</div></div>'."\n";
}


?>
<div class="row"  style="margin-top:15px;">
<div class="col-md-4 col-md-offset-1 ">
	<h5 class="text-info showInformation">จองแล้ว : </h5><h5 class="text-info showInformation" id="textBooked"><?php echo $countSeatBooked;?></h5>
	<h5 class="text-info showInformation ">ยังไม่ได้จอง : </h5><h5 class="text-info showInformation" id="textNoneBook"><?php echo $countRow-$countSeatBooked;?> </h5>
	</div>
  <div class="col-md-4 col-md-offset-3">
    <form action="#" method="POST" id="form_cancel" >
      <div class="col-lg-4 block" align="right">
        <label>Delete Seat</label>
      </div>
      <div class="col-lg-6">
        <div class="input-group">
          <input type="text" class="form-control" name="cancel" value="" id="valueDeleteSeat" readonly>
          <span class="input-group-btn">
            <button class="btn btn-default" type="submit" >
              Confirm
            </button> </span>
        </div>
      </div><!-- /input-group -->
    </form>
</div>


</div>
</div>
<div id="footer">
      <div class="container">
        <p class="muted credit">Faculty of Engineering Student Union @ Khon Kaen University  © 2015</p>
      </div>
    </div>
<input type="hidden" value="<?php echo $round; ?>" id="round">
<input type="hidden" value="" id="idDeleteSeat">
</body>
<script src="js/jquery-2.1.3.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {


    $(".seat").on('click',function() {

    var id=this.id;
    var value=this.text;
    var round=$('#round').val();
    if($(this).hasClass("seatBooking")){
      $.ajax({
        type: "POST",
        url: 'updateAdd.php',
        data: {"id":id,"round":round},
        success: function(data){
          if(data=='save'){
            $('#'+id).removeClass('seatBooking').addClass('seatbooked');
            $('#idDeleteSeat').val(id);
            $('#valueDeleteSeat').val(value);
      			var textBooked=	parseInt($('#textBooked').html());
      			$('#textBooked').html(textBooked+1);
      			var textNoneBook=	parseInt($('#textNoneBook').html());
      			$('#textNoneBook').html(textNoneBook-1);
          }else {
            alert(data);
          }
        }});
    }else {

      $('#idDeleteSeat').val(id);
      $('#valueDeleteSeat').val(value);
    }
  });

   $("#form_cancel").on('submit',function(){
     var round=$('#round').val();
     var id=$('#idDeleteSeat').val();
     if($('#valueDeleteSeat')!=""){
        $.ajax({
          type: "POST",
          url: 'seatDelete.php',
          data: {"id":id,"round":round},
          success: function(data){
            if(data=='save'){
              $('#'+id).removeClass('seatbooked').addClass('seatBooking');
		  	      var textBooked=	parseInt($('#textBooked').html());
			        $('#textBooked').html(textBooked-1);
        			var textNoneBook=	parseInt($('#textNoneBook').html());
        			$('#textNoneBook').html(textNoneBook+1);

            }else {
              alert(data);
            }

          }});
        }
      return false;
   });

  $("#roundSelcet").on('change',function(){
    window.location.href = "booking.php?round="+this.value;

  });

$( ".seat" ).on('blur',function() {
  $('#valueDeleteSeat').val("");

});


});
</script>
</html>
