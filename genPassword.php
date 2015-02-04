<?php

	        if(!isset($_POST['password'])){
                echo "Can not input password";
                exit(0);
        }

	echo $_POST['password']."<br>";
        echo sha1("EN-kku".$_POST['password']."@NN27");




?>
