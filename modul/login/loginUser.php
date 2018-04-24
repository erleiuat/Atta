<?php

    include("../../include/database.php");

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = test_input($_POST['email']);
    $password = $_POST['password'];
    $error = "";

    if(!$email){
        $error .= "<li>Please enter a correct E-Mail</li>";
    }

    if(!$password){
        $error .= "<li>Please enter a Password</li>";
    }

    if($error){
        echo $error;
    } else {

        if (!($stmt = $mysqli->prepare("SELECT password FROM `tb_user` WHERE email = ?;"))) {
             echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }

        if (!$stmt->bind_param("s", $email)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_NUM);

        if (!password_verify($password, $row[0])) {
            echo '<li>Incorrect Password</li>';
            die();
        } else {

            session_start();
            ini_set('session.cookie_lifetime', 60 * 60 * 24 * 100);
            ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 100);

            $_SESSION = array(
                'user'  => array(
                    'username'  => $row['username'],
                    'id' => $row['ID']
                )
            );

            header("Refresh:0");

        }

        $stmt->close();

    }

?>
