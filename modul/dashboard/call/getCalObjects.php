<?php

    include("../../../include/session.php");
    include("../../../include/database.php");

    $sql = "SELECT * FROM `tb_user_object` WHERE tb_user_ID = $session_userid;";
    $res = $mysqli->query($sql);
    if (isset($res) && $res->num_rows > 0) {
        while($row = $res->fetch_assoc()) {

            if(!$row['img_path']){
                $row['img_path'] = "default.png";
            }

            echo '
            <!-- CalObject -->
            <div class="row card selectCalories highlighter" obj_title="'.$row['title'].'" obj_calories="'.$row['calories'].'" obj_amount="'.$row['amount'].'">
                <div class="col-12">
                    <div class="row">
                        <div class="col-4 col-xs-2 my-auto">
                            <img src="img/calObjects/'.$row['img_path'].'" class="img-fluid" alt="objectImg" />
                        </div>
                        <div class="col-8 col-xs-10 my-auto">
                            <div class="col-12">
                                <b>'.$row['title'].'</b>
                            </div>
                            <div class="col-12">
                                '.$row['calories'].' Calories
                            </div>
                            <div class="col-12">
                                Default Amount: '.$row['amount'].'
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ';

        }
    }

?>

<script>
    $(document).ready(function(){

        $('.selectCalories').each(function(){
            $(this).click(function(){

                $('#inputCalTitle').val($(this).attr('obj_title'));
                $('#inputCal').val($(this).attr('obj_calories'));
                $('#inputCalAmount').val($(this).attr('obj_amount'));

                $('#calSelectModal').modal('toggle');

            });
        });

    });
</script>
