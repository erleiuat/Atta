<?php

    include("../../include/session.php");
    include("../../include/database.php");
    include("../../include/alerts.php");

    if($session_loggedin == false){
        echo '<script type="text/javascript">parent.window.location.reload();</script>';
        exit();
    }

    $timeNow = date('Y-m-d H:i:s');

?>
<section class="resume-section p-3 p-lg-5 d-flex d-column" id="about">
    <div class="my-auto col-12">

        <h1 class="mb-0">
            <span class="text-primary">Board</span>
        </h1>
        <br/>
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="card">
                    <div class="col-12 text-center">
                        <h4>Add entry</h4>
                        <form>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Date & Time</label>
                                <input type="datetime" class="form-control" id="inputDate" value="<?php echo $timeNow; ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Weight</label>
                                <input type="number" class="form-control" id="inputWeight" placeholder="Your Weight">
                            </div>
                            <button type="button" class="btn btn-default btn-block" id="addEntryButton">Add</button>
                            <br/>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="facts">
            <!-- GET FACTS -->
        </div>

        <div class="row" id="entries">
            <!-- GET ENTRIES -->
        </div>

    </div>
</section>
<script type="text/javascript" src="modul/dashboard/dashboard.min.js"></script>
