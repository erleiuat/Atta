<div class="col-12">
    <hr/>
    <h4>Facts</h4>
    <?php

        include("../../include/session.php");
        include("../../include/database.php");

        $sql = "SELECT age, height, weight, aim_date, aim_weight, gender FROM tb_user WHERE ID = $session_userid";
        $sql2 = "SELECT weight FROM tb_user_weight WHERE tb_user_ID = $session_userid ORDER BY date_entered DESC LIMIT 2";
        $sql3 = "SELECT weight, date_entered FROM tb_user_weight WHERE tb_user_ID = $session_userid ORDER BY date_entered ASC LIMIT 1";
        $sql4 = "SELECT * FROM `tb_user_cal` where entryDate >= CAST(CURRENT_TIMESTAMP AS DATE) AND tb_user_ID = $session_userid";

        $res = $mysqli->query($sql);
        if (isset($res) && $res->num_rows > 0) {
            $row = $res->fetch_assoc();

            $user_age = $row['age'];
            $user_height = $row['height'];
            $user_aimDate = $row['aim_date'];
            $user_aimWeight = $row['aim_weight'];
            $user_gender = $row['gender'];

        }

        $oldWeight = "";
        $newWeight = "";

        $res = $mysqli->query($sql2);
        if (isset($res) && $res->num_rows > 0) {
            while($row = $res->fetch_assoc()){

                if($newWeight == ""){
                    $newWeight = $row['weight'];
                } else {
                    $oldWeight = $row['weight'];
                }

            }
        }

        $res = $mysqli->query($sql3);
        if (isset($res) && $res->num_rows > 0) {
            $row = $res->fetch_assoc();

            $user_start_weight = $row['weight'];
            $user_start_weight_date = $row['date_entered'];

        }

    ?>
</div>
<div class="col-12">
    <div class="row">

        <!-- Calculate the difference between the last 2 Entries -->
        <div class="col-lg-4">
            <?php
                if(is_numeric($oldWeight) && is_numeric($newWeight)){
                    $echo = round($newWeight - $oldWeight,2) . " KG";
                } else {
                    $echo = "<h4>missing entry</h4>";
                }
            ?>
            <div class="card factCard <?php if($echo < 0){echo "alert-success";}else if($echo > 0){echo "alert-danger";} ?>">
                <div class="col-12">
                    <b>Difference last 2 entries</b>
                </div>
                <div class="col-12 text-center">
                    <h2>
                        <?php echo $echo; ?>
                    </h2>
                </div>
            </div>
        </div>

        <!-- Calculate the difference between the first and the last Entry -->
        <div class="col-lg-4">
            <?php
                if(is_numeric($newWeight) && is_numeric($user_start_weight)){
                    $echo = round($newWeight - $user_start_weight,2) . " KG";
                } else {
                    $echo = "<h4>missing entry</h4>";
                }
            ?>
            <div class="card factCard <?php if($echo < -10){echo "alert-success";} ?>">
                <div class="col-12">
                    <b>Difference first and latest entry</b>
                </div>
                <div class="col-12 text-center">
                    <h2>
                        <?php echo $echo; ?>
                    </h2>
                    <?php
                        $your_date = strtotime(substr($user_start_weight_date, 0, -9));;
                        $datediff = time() - $your_date;
                        echo "In ".( round($datediff / (60 * 60 * 24)) - 1 ). " Days";
                    ?>
                </div>
            </div>
        </div>

        <!-- Calculate the difference between the current and target Weight -->
        <div class="col-lg-4">
            <?php

                if(is_numeric($newWeight) && is_numeric($user_aimWeight)){
                    $neededLoss = $user_aimWeight - $newWeight;
                    $echo = round($neededLoss)." KG";
                } else {
                    $echo = "<h4>missing entry</h4><script type='text/javascript'>dataCheck();</script>";
                }

            ?>
            <div class="card factCard <?php if($echo >= -5){echo "alert-success";}else if($echo >= -10){echo "alert-primary";}else{echo "alert-danger";} ?>">
                <div class="col-12">
                    <b>Difference current & target weight</b>
                </div>
                <div class="col-12 text-center">
                    <h2>
                        <?php echo $echo; ?>
                    </h2>

                    <?php

                        if($user_aimDate != ""){

                            $now = time(); // or your date as well
                            $your_date = strtotime($user_aimDate);
                            $datediff = $your_date - $now;

                            $daysToAim = round($datediff / (60 * 60 * 24));

                            if(isset($daysToAim) && isset($neededLoss) && is_numeric($daysToAim) && is_numeric($neededLoss)){
                                $dailyNeededLoss = round($neededLoss/$daysToAim, 3);
                                if($dailyNeededLoss <= 0){
                                    $echoNeededLoss = "Lose " .$dailyNeededLoss . " KG for ".$daysToAim." Days to reach aims";
                                } else {
                                    $echoNeededLoss = "Gain " .$dailyNeededLoss . " KG for ".$daysToAim." Days to reach aims";
                                }

                            } else {
                                $echoNeededLoss = $daysToAim;
                            }

                        }

                        if(isset($echoNeededLoss)){
                            echo $echoNeededLoss;
                        }

                    ?>

                </div>
            </div>
        </div>

        <!-- Calculate the BMI -->
        <div class="col-lg-4">
            <?php

                if(is_numeric($newWeight) && is_numeric($user_height)){
                    $echo = round($newWeight / (($user_height/100)*($user_height/100)), 2);
                } else {
                    $echo = "<h4>missing entry</h4>";
                }

            ?>
            <div class="card factCard
            <?php
                if($echo < 24 && $echo > 17){
                    echo "alert-success";
                }else if($echo < 17 && $echo > 15 || $echo > 24 && $echo < 27){
                    echo "alert-primary";
                }else{
                    echo "alert-danger";
                }
            ?>">
                <div class="col-12">
                    <b>Current BMI</b> <a href="#" data-toggle="tooltip" data-placement="right" title="Your BMI (Body-Mass-Index) should be between 18-24">
                        <i class="far fa-question-circle"></i>
                    </a>
                </div>
                <div class="col-12 text-center">
                    <h2>
                        <?php echo $echo; ?>
                    </h2>
                    Should be 20-25
                </div>
            </div>
        </div>

        <!-- Calculate the possible calories to reach aimed weight on aimed date -->
        <div class="col-lg-4">
            <?php

                if(is_numeric($newWeight) && is_numeric($user_height) && is_numeric($user_age)){

                    if($user_gender == 0){
                        $dailyCalneeded = 66 + (13.8 * $newWeight) + (5.0 * $user_height) + (6.8 * $user_age); //Mans
                    } else if ($user_gender == 1){
                        $dailyCalneeded = 655 + (9.5 * $newWeight) + (1.9 * $user_height) + (4.7 * $user_age); //Womans
                    } else {
                        $dailyCalneeded = "No Gender found";
                    }

                }

                if(isset($dailyNeededLoss) && is_numeric($dailyNeededLoss) && is_numeric($dailyCalneeded)){

                    $neededLossInCal = 7000 * ($dailyNeededLoss);

                    $dailyCalToReachAims = $dailyCalneeded - ((-1)*$neededLossInCal);

                    $echo = round($dailyCalToReachAims);

                } else {
                    $echo = "<h4>missing entry</h4>";
                }

            ?>
            <div class="card factCard
            <?php
                if($echo >= 1000){
                    echo "alert-success";
                }else if($echo < 1000 && $echo >= 800){
                    echo "alert-primary";
                }else{
                    echo "alert-danger";
                }
            ?>">
                <div class="col-12">
                    <b>
                        <?php
                            if($echoNeededLoss <= 0){
                                echo "Daily <i>max.</i> calories to reach aims";
                            } else {
                                echo "Daily <i>min.</i> calories to reach aims";
                            }
                        ?>
                    </b> <a href="#" data-toggle="tooltip" data-placement="right" title="With this amount of calories per day you'll achive your weight goal on the chosen day">
                        <i class="far fa-question-circle"></i>
                    </a>
                </div>
                <div class="col-12 text-center">
                    <h2>
                        <?php echo $echo; ?>
                    </h2>
                    <?php echo "Your daily basal metabolism: ". $dailyCalneeded. " Calories";?>
                </div>
            </div>
        </div>

        <!-- Calculate the today still available cals -->
        <div class="col-lg-4">
            <?php

                if(isset($dailyCalToReachAims) && is_numeric($dailyCalToReachAims)){

                    $caloriesUsed = 0;

                    $res = $mysqli->query($sql4);
                    if (isset($res) && $res->num_rows > 0) {
                        while($row = $res->fetch_assoc()){

                            $caloriesUsed += $row['calories']*$row['amount'];

                        }
                    }

                    $echo = $dailyCalToReachAims - $caloriesUsed;

                } else {
                    $echo = "<h4>missing entry</h4>";
                }



            ?>
            <div class="card factCard
            <?php
                if($echo > 200){
                    echo "alert-success";
                }else if($echo <= 200 && $echo >= 0){
                    echo "alert-primary";
                }else{
                    echo "alert-danger";
                }
            ?>">
                <div class="col-12">
                    <b>Still available Calories </b> <a href="#" data-toggle="tooltip" data-placement="right" title="Thats what you still can eat today.">
                        <i class="far fa-question-circle"></i>
                    </a>
                </div>
                <div class="col-12 text-center">
                    <h2>
                        <?php echo round($echo, 2); ?>
                    </h2>
                    <?php echo "Already took ". $caloriesUsed . " today"; ?>
                </div>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="tooltip"]').each(function(){
            $(this).click(function(event){
                event.preventDefault();
            });
        });
    });
</script>
