<?php

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function generateRandomString($length = 30) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function uploadFile($image){

        $fileName = generateRandomString() . ".png";
        $filePath = "../../../img/calObjects/" . $fileName;

        if(file_exists($filePath)) {
            $id = 1;
            do {
                $fileName = generateRandomString() . ".png";
                $filePath = "../../../img/calObjects/" . $fileName;
                $id++;
            } while(file_exists($filePath));
        }

        file_put_contents($filePath, $image);

        return $fileName;

    }

    if($_POST['f_new_image']){
        $img = $_POST['f_new_image'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $fImage = uploadFile(base64_decode($img));
    } else {
        $fImage = "";
    }

    $fTitle = test_input($_POST['f_new_title']);
    $fCalories = test_input($_POST['f_new_calories']);
    $fAmount = test_input($_POST['f_new_amount']);

    include("../../../include/session.php");
    include("../../../include/database.php");

    $error = "";

    if($error){
        $error .= $error;
    } else {

        if (!($stmt = $mysqli->prepare("INSERT INTO `tb_user_object` (`img_path`, `title`, `calories`, `amount`, `tb_user_ID`) VALUES (?, ?, ?, ?, ?);"))) {
             $error .= "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }

        if (!$stmt->bind_param("ssddi", $fImage, $fTitle, $fCalories, $fAmount, $session_userid)) {
            $error .= "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        if (!$stmt->execute()) {
            $error .= "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $stmt->close();

    }

    if($error){
        header('Location: ../?page=objects/objects&error='.$error);
    } else {
        header('Location: ../../../?page=objects/objects&success=true');
    }


?>
