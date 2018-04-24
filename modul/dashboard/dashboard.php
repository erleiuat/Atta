<?php

    include("../../include/session.php");

    if(!$session_loggedin){
        echo '<script type="text/javascript">parent.window.location.reload();</script>';
        exit();
    }

?>
<section class="resume-section p-3 p-lg-5 d-flex d-column" id="about">
    <div class="my-auto">

        <h1 class="mb-0">Atta
            <span class="text-primary">Dashboard</span>
        </h1>

    </div>
</section>
