<?php

    include("../../include/session.php");
    include("../../include/alerts.php");

?>
<section class="resume-section p-3 p-lg-5 d-flex d-column" id="about">
    <div class="my-auto">

        <h2 class="mb-0 text-center">Atta
            <span class="text-primary">Login</span>
        </h2>
        <br/>
        <div class="row">
            <div class="col-10 offset-1">
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="inputMail" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="password" class="form-control" id="inputPassword" placeholder="Enter Password">
                    </div>
                    <button type="submit" id="loginButton" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="modul/login/login.js"></script>
