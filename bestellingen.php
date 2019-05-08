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
    
<body>
<form action="#" method= "POST">
    <input type="submit" name="bonmaken" value="bon maken" />



    <input type="submit" name="terug" value="terug" />



    <input type="submit" name="anderetafel" value="andere tafel" />



</form>
</div>
<?php 


$stmt_eten = $user->runQuery("SELECT pnaam, prijs FROM products");
$stmt_eten->execute();


echo "<table border='1' class= 'tableres'  >
			
			<h1 class='titlepr'>Warme eten</h1>
			<tr>
			 
			<th>Product naam</th>
			<th>Product prijs</th>
			
		
			</tr>";
 while($row_eten= $stmt_eten->fetch(\PDO::FETCH_ASSOC)){
    echo "<tr>";
			echo "<td><a href='".'.php'."'>".$row_eten['pnaam']."</td>";
			echo "<td>".$row_eten['prijs']."</td>";
			
                 
       

			echo "</tr>";
		
		}
			echo "</table>";



if(isset($_POST["terug"])){
header("location:hoofdvenster.php");	
}