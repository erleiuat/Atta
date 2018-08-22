<?php

    include("../../../include/session.php");
    include("../../../include/database.php");

    if(!$session_loggedin){
        exit();
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function amk_img_resize($target, $newcopy, $w, $h, $ext) {

        list($w_orig, $h_orig) = getimagesize($target);
        $scale_ratio = $w_orig / $h_orig;

        if (($w / $h) > $scale_ratio) {
            $w = $h * $scale_ratio;
        } else {
            $h = $w / $scale_ratio;
        }

        $img = "";
        $ext = strtolower($ext);

        if ($ext == "gif"){
            $img = imagecreatefromgif($target);
        } else if($ext =="png"){
            $img = imagecreatefrompng($target);
        } else {
            $img = imagecreatefromjpeg($target);
        }

        $tci = imagecreatetruecolor($w, $h);
        imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
        imagejpeg($tci, $newcopy, 80);

    }

    $fTitle = test_input($_POST['f_new_title']);
    $fCalories = test_input($_POST['f_new_calories']);
    $fAmount = test_input($_POST['f_new_amount']);

    $fileName = $_FILES["uploaded_file"]["name"];
    $fileTmpLoc = $_FILES["uploaded_file"]["tmp_name"];
    $fileType = $_FILES["uploaded_file"]["type"];
    $fileExt = end(explode(".", $fileName));

    if (!$fileTmpLoc) { //
        //Nothing
        $fileName = "";
    } else if (!preg_match("/.(jpg|png)$/i", $fileName) ) {
         echo "ERROR: Your image was not .jpg, or .png.";
         unlink($fileTmpLoc);
         exit();
    }

    $moveResult = move_uploaded_file($fileTmpLoc, "../../../img/calObjects/$fileName");

    if ($moveResult != true) {
        unlink($fileTmpLoc);
    }
    unlink($fileTmpLoc);

    $target_file = "../../../img/calObjects/$fileName";
    $resized_file = "../../../img/calObjects/resized_$fileName";
    $wmax = 200;
    $hmax = 150;
    amk_img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);

    unlink($target_file);

    include("../../../include/session.php");
    include("../../../include/database.php");

    $error = "";

    if($error){
        $error .= $error;
    } else {

        if (!($stmt = $mysqli->prepare("INSERT INTO `tb_user_object` (`img_path`, `title`, `calories`, `amount`, `tb_user_ID`) VALUES (?, ?, ?, ?, ?);"))) {
             $error .= "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
        }

        if (!$stmt->bind_param("ssddi", $fileName, $fTitle, $fCalories, $fAmount, $session_userid)) {
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
