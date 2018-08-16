<?php

    include("../../../include/database.php");
    include("../../../include/session.php");

    if($session_loggedin == false){
        echo '<script type="text/javascript">parent.window.location.reload();</script>';
        exit();
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $date = test_input($_POST['date']);
    $weight = test_input($_POST['weight']);
    $error = "";

    if(!$date){
        $error .= "<li>Please enter a Date</li>";
    }

    if(!$weight){
        $error .= "<li>Please enter a weight</li>";
    }

    if($error){
        echo $error;
    } else {

        if (!($stmt = $mysqli->prepare("INSERT INTO `tb_user_weight` (`date_entered`, `weight`, `tb_user_ID`) VALUES (?, ?, ?);"))) {
             echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }

        if (!$stmt->bind_param("sdi", $date, $weight, $session_userid)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $stmt->close();

    }

?>
