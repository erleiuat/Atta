<?php

    include("../../include/session.php");
    include("../../include/alerts.php");

    if($session_loggedin){
        echo '<script type="text/javascript">parent.window.location.reload();</script>';
    }

?>
<section class="resume-section p-3 p-lg-5 d-flex d-column" id="about">
    <div class="my-auto">

        <h1 class="mb-0">Atta
            <span class="text-primary">Register</span>
        </h1>
        <br/>
        <div class="row">
            <div class="col-10 offset-1">
                <form id="regForm">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Firstname</label>
                        <input type="text" class="form-control" id="inputFirstname" placeholder="Enter Firstname">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Lastname</label>
                        <input type="text" class="form-control" id="inputLastname" placeholder="Enter Lastname">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">E-Mail</label>
                        <input type="text" class="form-control" id="inputMail" placeholder="Enter E-Mail">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="password" class="form-control" id="inputPassword" placeholder="Enter Password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Repeat Password</label>
                        <input type="password" class="form-control" id="inputPasswort2" placeholder="Repeat Password">
                    </div>
                    <button type="submit" id="registerButton" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="modul/register/register.js"></script>
