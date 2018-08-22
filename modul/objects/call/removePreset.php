<?php

    include("../../../include/session.php");
    include("../../../include/database.php");

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

    $entryID = test_input($_POST['objectID']);
    $error = "";

    if(!$entryID){
        $error .= "<li>Failed to delete</li>";
    }

    $sql = "SELECT img_path FROM `tb_user_object` WHERE ID = $entryID AND tb_user_ID = $session_userid";
    $res = $mysqli->query($sql);
    if (isset($res) && $res->num_rows == 1) {

        $row = $res->fetch_assoc();

        if($error){
            echo $error;
        } else {

            if (!($stmt = $mysqli->prepare("DELETE FROM `tb_user_object` WHERE `tb_user_object`.`ID` = ?;"))) {
                 echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }

            if (!$stmt->bind_param("i", $entryID)) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            if (!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            $stmt->close();
            unlink('../../../img/calObjects/resized_'.$row['img_path']);

        }

    } else {
        echo "Entry Permissions denied.";
    }

?>
