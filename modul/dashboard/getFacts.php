<div class="col-12">
    <hr/>
    <h4>Facts</h4>
    <?php

        include("../../include/session.php");
        include("../../include/database.php");

        $sql = "SELECT age, height, weight, aim_date, aim_weight FROM tb_user WHERE ID = $session_userid";
        $sql2 = "SELECT weight FROM tb_user_weight WHERE tb_user_ID = $session_userid ORDER BY date_entered DESC LIMIT 2";
        $sql3 = "SELECT weight FROM tb_user_weight WHERE tb_user_ID = $session_userid ORDER BY date_entered ASC LIMIT 1";

        $res = $mysqli->query($sql);
        if (isset($res) && $res->num_rows > 0) {
            $row = $res->fetch_assoc();

            $user_age = $row['age'];
            $user_height = $row['height'];
            $user_aimDate = $row['aim_date'];
            $user_aimWeight = $row['aim_weight'];

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

        }

    ?>
</div>
<div class="col-12">
    <div class="row">

        <div class="col-lg-4">
            <div class="card factCard">
                <div class="col-12">
                    <b>Difference last 2 entries:</b>
                </div>
                <div class="col-12 text-center">
                    <h2>
                        <?php
                            if(is_numeric($oldWeight) && is_numeric($newWeight)){
                                echo $newWeight - $oldWeight . " KG";
                            } else {
                                echo "missing entry";
                            }
                        ?>
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card factCard">
                <div class="col-12">
                    <b>Difference first and latest entry:</b>
                </div>
                <div class="col-12 text-center">
                    <h2>
                        <?php
                            if(is_numeric($newWeight) && is_numeric($user_start_weight)){
                                echo $newWeight - $user_start_weight . " KG";
                            } else {
                                echo "missing entry";
                            }
                        ?>
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card factCard">
                <div class="col-12">
                    <b>Difference current - target weight:</b>
                </div>
                <div class="col-12 text-center">
                    <h2>
                        <?php

                            if(is_numeric($newWeight) && is_numeric($user_aimWeight)){
                                echo $user_aimWeight - $oldWeight ." KG";
                            } else {
                                echo "missing entry";
                            }

                        ?>
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card factCard">
                <div class="col-12">
                    <b>Current BMI:</b>
                </div>
                <div class="col-12 text-center">
                    <h2>
                        20.5
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card factCard">
                <div class="col-12">
                    <b>Days till goal Date:</b>
                </div>
                <div class="col-12 text-center">
                    <h2>
                        95
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card factCard">
                <div class="col-12">
                    <b>Daily needed loss:</b>
                </div>
                <div class="col-12 text-center">
                    <h2>
                        0.2083 KG
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card factCard">
                <div class="col-12">
                    <b>Daily Calories:</b>
                </div>
                <div class="col-12 text-center">
                    <h2>
                        850 Cal
                    </h2>
                </div>
            </div>
        </div>

    </div>
</div>
