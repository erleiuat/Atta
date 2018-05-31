<?php

    include("../../include/database.php");
    include("../../include/session.php");

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

    $entryID = test_input($_POST['entryID']);
    $error = "";

    if(!$entryID){
        $error .= "<li>Failed to delete</li>";
    }

    if($error){
        echo $error;
    } else {

        if (!($stmt = $mysqli->prepare("DELETE FROM `tb_user_cal` WHERE `tb_user_cal`.`ID` = ?;"))) {
             echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }

        if (!$stmt->bind_param("i", $entryID)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $stmt->close();

    }

?>
