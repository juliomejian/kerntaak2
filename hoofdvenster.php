<?php 
session_start();

require_once 'core/User.php';

$user = new Core\User();

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/main.css" >

    <title>Restaurant Excellent</title>
</head>
<body>
<div class="container-fluid">
    <html>
<body>
<form action="#" method= "POST">
    <input type="submit" name="bestellingen" value="Bestellingen" />


</form>
<form action="#" method= "POST">

    <input type="submit" name="eserveringen" value="Reserveringen" />
</form>


<form action="overzichtkok.php" method= "POST">


    <input type="submit" name="overzichten" value="Overzicht kok" />
</form>


<?php 

//Dropdown tafels

$stmt_eten = $user->runQuery("SELECT tafelnummer FROM tafel");
$stmt_eten->execute();
	
	echo "<div class='tafel'>";
	echo "<h5 class>Tafel</h5>";
	echo "<select name='Tafels'>";
 		
 		while($row_eten= $stmt_eten->fetch(\PDO::FETCH_ASSOC)){
    		echo '<option value="">'.$row_eten['tafelnummer'].'</option>';
 }
	echo "</select>";
	echo "</div>";

//Overzicht reserveringen 

if(isset($_POST["reserveringen"])){

	$stmt_reserveringen_item = $user->runQuery("SELECT * FROM tafel_reservering");
	$stmt_reserveringen_item->execute();
	
		echo "<table border='1' class= 'tableres'>
			<tr>
			<th>Naam</th>
			<th>Aantal Personen</th>
			<th>Datum</th>
			<th>Tijd</th>
			<th>TelefoonNr</th>
			<th>Allergieen</th>
			<th>Overigeinfo</th>

			</tr>";
		while($row_reserveringen_item= $stmt_reserveringen_item->fetch(PDO::FETCH_ASSOC)){
			echo "<tr>";
			echo "<td><a href='".'bestellingen.php'."'>".$row_reserveringen_item['Naam']."</td>";
			echo "<td><a href='".'bestellingen.php'."'>".$row_reserveringen_item['aantal_personen']."
				</td>";;
			echo "<td><a href='".'bestellingen.php'."'>".$row_reserveringen_item['datum']."</td>";
			echo "<td><a href='".'bestellingen.php'."'>".$row_reserveringen_item['tijd']."</td>";
			echo "<td><a href='".'bestellingen.php'."'>".$row_reserveringen_item['telefoonnr']."</td>";
			echo "<td><a href='".'bestellingen.php'."'>".$row_reserveringen_item['allergieen']."</td>";
			echo "<td><a href='".'bestellingen.php'."'>".$row_reserveringen_item['overigeinfo']."</td>";
			echo "</tr>";
		}
			echo "</table>";
}

 
if(isset($_POST["bestellingen"])){
	echo "<h1 class='errorbestellingen'>Error, u moet eerst een reservering maken</h1>";
}

if(isset($_POST["overzichten"])){


?>
<!--Jumbotron-->
<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">Overzicht kok</h1>
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
<?php 
}?>



