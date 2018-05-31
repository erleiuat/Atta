<div class="col-12">
    <hr/>
    <h4>Last entries</h4>
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

                include("../../include/session.php");
                include("../../include/database.php");

                $i = 1;

                $sql = "SELECT ID, date_entered, weight FROM tb_user_weight WHERE tb_user_ID = $session_userid ORDER BY date_entered DESC LIMIT 10";
                $res = $mysqli->query($sql);

                if (isset($res) && $res->num_rows > 0) {
                    while($row = $res->fetch_assoc()) {

                        echo '
                        <tr>
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
