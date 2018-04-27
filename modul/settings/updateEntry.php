<?php

    include("../../include/session.php");
    include("../../include/database.php");

    if(!$session_loggedin){
        echo '<script type="text/javascript">parent.window.location.reload();</script>';
        exit();
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $firstname = test_input($_POST['firstname']);
    $lastname = test_input($_POST['lastname']);
    $age = test_input($_POST['age']);
    $height = test_input($_POST['height']);
    $aim_date = test_input($_POST['aim_date']);
    $aim_weight = test_input($_POST['aim_weight']);
    $gender = test_input($_POST['gender']);
    $error = "";

    if($error){
        echo $error;
    } else {

        if (!($stmt = $mysqli->prepare("UPDATE `tb_user` SET `firstname` = ?, `lastname` = ?, `age` = ?, `height` = ?, `aim_date` = ?, `aim_weight` = ?, `gender` = ? WHERE `tb_user`.`ID` = ?;"))) {
             echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }

        if (!$stmt->bind_param("ssidsdii", $firstname, $lastname, $age, $height, $aim_date, $aim_weight, $gender, $session_userid)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $stmt->close();

    }

?>
