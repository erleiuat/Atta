<?php

    if(!isset($_SESSION['user'])){

        session_start();

    }

    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {

        session_destroy();
        $session_loggedin = false;
        echo '<script type="text/javascript">parent.window.location.reload();</script>';
        exit();

    } else {

        session_regenerate_id();

        $_SESSION['LAST_ACTIVITY'] = time();

        if(isset($_SESSION['user']['username'])  && isset($_SESSION['user']['id'])){

            $session_username = $_SESSION['user']['username'];
            $session_userid = $_SESSION['user']['id'];
            $session_loggedin = true;

        } else {

            $session_loggedin = false;

        }

    }

?>
