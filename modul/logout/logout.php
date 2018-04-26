<?php
     session_start();
     session_destroy();
     $session_loggedin = false;
     echo '<script type="text/javascript">parent.window.location.reload();</script>';
     exit();
?>
