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

    $title = test_input($_POST['title']);
    $date = test_input($_POST['date']);
    $amount = test_input($_POST['amount']);
    $calories = test_input($_POST['calories']);
    $error = "";

    if(!$date){
        $error .= "<li>Please enter a Date</li>";
    }

    if(!$amount){
        $error .= "<li>Please enter an amount</li>";
    }

    if(!$calories){
        $error .= "<li>Please enter Calories</li>";
    }

    if($error){
        echo $error;
    } else {

        if (!($stmt = $mysqli->prepare("INSERT INTO `tb_user_cal` (`entryDate`, `title`, `amount`, `calories`, `tb_user_ID`) VALUES (?, ?, ?, ?, ?);"))) {
             echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }

        if (!$stmt->bind_param("ssddi", $date, $title, $amount, $calories, $session_userid)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $stmt->close();

    }

?>
