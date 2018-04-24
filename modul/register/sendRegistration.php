<?php

    include("../../include/database.php");

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $firstname = test_input($_POST['firstname']);
    $lastname = test_input($_POST['lastname']);
    $email = test_input($_POST['email']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $error = "";

    if(!$firstname){
        $error .= "<li>Please enter your Firstname</li>";
    }

    if(!$lastname){
        $error .= "<li>Please enter your Lastname</li>";
    }

    if(!$email){
        $error .= "<li>Please enter a correct E-Mail</li>";
    }

    if(!$password){
        $error .= "<li>Please enter a Password</li>";
    } else {
        if($password != $password2){
            $error .= "<li>The Passwords are not similar</li>";
        }
    }

    if($error){
        echo $error;
    } else {

        $password = password_hash($password, PASSWORD_BCRYPT, ["cost" => 11]);

        if (!($stmt = $mysqli->prepare("INSERT INTO `tb_user` (`firstname`, `lastname`, `email`, `password`) VALUES (?, ?, ?, ?);"))) {
             echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }

        if (!$stmt->bind_param("ssss", $firstname, $lastname, $email, $password)) {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $stmt->close();

    }


?>
