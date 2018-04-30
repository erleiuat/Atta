<?php

    session_start();

    if(isset($_SESSION['user'])){
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {

            if(!$_SESSION['user']['keepLogin']){
                echo "Nice";
                session_destroy();
                $session_loggedin = false;
                echo '<script type="text/javascript">parent.window.location.reload();</script>';
                exit();
            } else {
                echo "Naninu";
            }

        } else {

            $_SESSION['LAST_ACTIVITY'] = time();

            if(isset($_SESSION['user']['email']) && isset($_SESSION['user']['id'])){

                $session_username = $_SESSION['user']['email'];
                $session_userid = $_SESSION['user']['id'];
                $session_loggedin = true;

                session_regenerate_id();

            } else {

                $session_loggedin = false;

            }

        }
    } else {
        $session_loggedin = false;
    }

?>
