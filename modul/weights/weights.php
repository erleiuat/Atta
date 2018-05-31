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

        <h2 class="mb-0">Weight</h2>
        <h4>Chart</h4>

        <div id="chartdiv" style="min-height: 500px; width:80vw;"></div>

        <div class="col-12">
            <h4>All entries</h4>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date | Time</th>
                        <th scope="col">Weight</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="allWeights">
                    <?php

                        $i = 1;

                        $sql = "SELECT ID, date_entered, weight FROM tb_user_weight WHERE tb_user_ID = $session_userid ORDER BY date_entered DESC";
                        $res = $mysqli->query($sql);

                        if (isset($res) && $res->num_rows > 0) {
                            while($row = $res->fetch_assoc()) {

                                echo '
                                <tr class="deletableEntry" entryID="'.$row['ID'].'">
                                    <th scope="row">'.$i.'</th>
                                    <td>'.substr($row['date_entered'], 0, -3).'</td>
                                    <td>'.$row['weight'].'</td>
                                    <td><a onclick="delEntry('.$row['ID'].')"><i style="cursor: pointer;" class="far fa-trash-alt"></i></a></td>
                                </tr>
                                ';

                                $i += 1;

                            }
                        } else {
                            echo '
                            <tr>
                                <th scope="row">-</th>
                                <td colspan="3">No entries yet</td>
                            </tr>
                            ';
                        }

                    ?>
                </tbody>
            </table>
        </div>

    </div>
</section>

<script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script type="text/javascript" src="https://www.amcharts.com/lib/3/serial.js"></script>
<script type="text/javascript" src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script type="text/javascript" src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<script type="text/javascript">
$(document).ready(function(){

    $.getScript( "https://www.amcharts.com/lib/3/serial.js", function( data, textStatus, jqxhr ) {
        console.log( data ); // Data returned
        console.log( textStatus ); // Success
        console.log( jqxhr.status ); // 200
        console.log( "Load was performed." );

        $.getScript( "https://www.amcharts.com/lib/3/plugins/export/export.min.js", function( data, textStatus, jqxhr ) {
            console.log( data ); // Data returned
            console.log( textStatus ); // Success
            console.log( jqxhr.status ); // 200
            console.log( "Load was performed." );

            $.getScript( "https://www.amcharts.com/lib/3/themes/light.js", function( data, textStatus, jqxhr ) {
                console.log( data ); // Data returned
                console.log( textStatus ); // Success
                console.log( jqxhr.status ); // 200
                console.log( "Load was performed." );

                var chart = AmCharts.makeChart("chartdiv", {
                "type": "serial",
                "theme": "light",
                "marginRight":80,
                "autoMarginOffset":20,
                "dataDateFormat": "YYYY-MM-DD HH:NN",
                "dataProvider": [
                <?php

                    $sql = "SELECT date_entered, weight FROM `tb_user_weight` WHERE tb_user_ID = $session_userid ORDER BY `date_entered` ASC";
                    $res = $mysqli->query($sql);

                    if (isset($res) && $res->num_rows > 0) {

                        $i = 0;

                        while($row = $res->fetch_assoc()) {
                            if($i < 1){

                                $firstdate = substr($row['date_entered'], 0, -9);
                                $firstvalue = $row['weight'];

                                echo '
                                {
                                    "date": "'.$firstdate.'",
                                    "value": '.$firstvalue.'
                                }
                                ';

                            } else {

                                $lastdate = substr($row['date_entered'], 0, -9);
                                $lastvalue = $row['weight'];

                                echo '
                                , {
                                    "date": "'.$lastdate.'",
                                    "value": '.$lastvalue.'
                                }
                                ';
                            }
                            $i++;
                        }
                    }

                ?>
                ],
                "valueAxes": [{
                    "axisAlpha": 0,
                    "guides": [{
                        "fillAlpha": 0.1,
                        "fillColor": "#888888",
                        "lineAlpha": 0,
                        "toValue": 16,
                        "value": 10
                    }],
                    "position": "left",
                    "tickLength": 0
                }],
                "graphs": [{
                    "balloonText": "[[category]]<br><b><span style='font-size:14px;'>value:[[value]]</span></b>",
                    "bullet": "round",
                    "dashLength": 3,
                    "colorField":"color",
                    "valueField": "value"
                }],
                "trendLines": [{
                    <?php
                        echo '
                        "finalDate": "'.$lastdate.' 12",
                        "finalValue": '.$lastvalue.',
                        "initialDate": "'.$firstdate.' 12",
                        "initialValue": '.$firstvalue.',
                        "lineColor": "#CC0000"
                        ';
                    ?>
                }],
                "chartScrollbar": {
                    "scrollbarHeight":2,
                    "offset":-1,
                    "backgroundAlpha":0.1,
                    "backgroundColor":"#888888",
                    "selectedBackgroundColor":"#67b7dc",
                    "selectedBackgroundAlpha":1
                },
                "chartCursor": {
                    "fullWidth":true,
                    "valueLineEabled":true,
                    "valueLineBalloonEnabled":true,
                    "valueLineAlpha":0.5,
                    "cursorAlpha":0
                },
                "categoryField": "date",
                "categoryAxis": {
                    "parseDates": true,
                    "axisAlpha": 0,
                    "gridAlpha": 0.1,
                    "minorGridAlpha": 0.1,
                    "minorGridEnabled": true
                },
                "export": {
                    "enabled": true
                 }
                });

                chart.addListener("dataUpdated", zoomChart);

                function zoomChart(){
                chart.zoomToDates(new Date(2012, 0, 2), new Date(2012, 0, 13));
                }

            });

        });

    });

});
</script>
<script type="text/javascript" src="modul/weights/weights.min.js"></script>
