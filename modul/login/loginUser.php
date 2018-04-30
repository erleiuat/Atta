<?php

    include("../../include/database.php");
    include("../../include/session.php");

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

        if (!($stmt = $mysqli->prepare("SELECT ID, password FROM `tb_user` WHERE email = ?;"))) {
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

        if(!isset($row)){
            echo '<li>E-Mail not found</li>';
            die();
        }

        if (!password_verify($password, $row[1])) {

            echo '<li>Incorrect Password</li>';
            die();

        } else {

            $_SESSION['user'] = array(
                'email'  => $email,
                'id' => $row[0],
                'keepLogin' => $_POST['keepLogin']
            );

        }

        $stmt->close();

    }

?>
