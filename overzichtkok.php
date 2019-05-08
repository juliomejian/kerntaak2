<?php
session_start();

require_once 'core/Rest.php';

$rest = new Core\Rest();

?>
<!--Jumbotron-->
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Overzicht kook</h1>
    </div>
</div>


<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 col-12">
        <table id="employee_data_user" class="table table-bordered table-condensed table-striped">
            <thead>
                <th>Tafel Nummer</th>
                <th>Eten Naam</th>
                <th>Eten Aantal</th>
                <th></th>
            </thead>
            <tbody>
            <?php
            //get admin information for table
            $stmt_table = $rest->runQuery("SELECT tp.tafel_id
                                                ,t.tafelnummer
                                                , tp.eten_aantal
                                                , ei.eten_item_name
                                                , t.betaald
                                            FROM tafel_product tp
                                            INNER JOIN eten_item ei
                                                on ei.eten_item_id = tp.eten_item_id
                                            INNER JOIN tafel t
                                                on t.tafel_id = tp.tafel_id
                                            WHERE t.betaald = 0 "//AND DATE(t.datum) = CURDATE()
            );
            $stmt_table->execute();
            while($row_table = $stmt_table->fetch(PDO::FETCH_ASSOC)):
                $tafelnummer = $row_table['tafelnummer'];
                $tafel_id = $row_table['tafel_id'];
                $eten_aantal = $row_table['eten_aantal'];
                $eten_item_name = $row_table['eten_item_name'];


                ?>
                <tr>
                    <td><?php echo $tafelnummer ; ?></td>
                    <td><?php echo $eten_item_name ; ?></td>
                    <td><?php echo $eten_aantal ; ?></td>
					<!--<td>
                        <a class="btn btn-sm btn-primary" href="overview_kook.php?tafel=<?php echo $tafel_id;?>">Bestel printen</a>
                    </td>
                </tr>//-->

            <?php endwhile;  ?>
     
			</tbody>
     	 </table>
		        <a href= "hoofdvenster.php">Terug</a>
    </div>
    <div class="col-md-2"></div>
</div>

