<?php
  if(!isset($_GET['code'])){

    exit(0);
  }else {
    $code=$_GET['code'];
  }

  switch ($code) {
    case 400:
      echo "<h1>400 Bad Request.</h1>";
      break;
    case 401:
        echo "<h1>401 Access denied.</h1>";
        break;
    case 404:
        echo "<h1>404::Not found.</h1>";
        break;
    case "green":
        echo "Your favorite color is green!";
        break;
    default:
        echo "<h1>404::Not found.</h1>";
}




?>
