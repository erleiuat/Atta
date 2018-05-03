<?php

    include("../../include/session.php");
    include("../../include/database.php");
    include("../../include/alerts.php");

    if(!$session_loggedin){
        echo '<script type="text/javascript">parent.window.location.reload();</script>';
        exit();
    }

?>
<section class="resume-section p-3 p-lg-5 d-flex d-column" id="about">
    <div class="my-auto">

        <h2 class="mb-0">Calories</h2>
        <div class="col-lg-12">
            <div class="row">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Date | Time</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Calories (p.p.)</th>
                            <th scope="col">Calories (total)</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                            $sql = "SELECT * FROM `tb_user_cal` WHERE tb_user_ID = $session_userid ORDER BY `tb_user_cal`.`entryDate`  DESC";

                            $res = $mysqli->query($sql);
                            if (isset($res) && $res->num_rows > 0) {
                                while($row = $res->fetch_assoc()){

                                    echo '
                                    <tr class="removableEntry" id="'.$row['ID'].'">
                                        <th scope="row">'.$row['title'].'</th>
                                        <td>'.$row['entryDate'].'</td>
                                        <td>'.$row['amount'].'</td>
                                        <td>'.$row['calories'].'</td>
                                        <td>'.$row['calories']*$row['amount'].'</td>
                                        <td class="deleteCalEntry" id="'.$row['ID'].'"><i style="cursor:pointer;" class="far fa-trash-alt"></i></td>
                                    </tr>
                                    ';

                                }
                            }

                        ?>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
</section>
<script type="text/javascript" src="modul/settings/settings.min.js"></script>
