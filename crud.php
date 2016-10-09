<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>CRUD-med-ressourcer</title>
</head>
<body>
<h2>Her kan du oprette et nyt projekt</h2>

<form method="post">
Projektnavn
<input type="text" name="navn" required>
Projekt beskrivelse
<input type="text" name="beskrivelse" required>
Start dato
<input type="date" name="start" required>
Slut dato
<input type="date" name="slut" required>
Xtra detaljer
<input type="text" name="detaljer" required>
Client ID
<select name="cnam">
   <?php
require_once 'dbcon.php';
$sql = 'SELECT c.Client_ID, c.name
FROM client c';
$stmt = $link->prepare($sql);
$stmt->execute();
$stmt->bind_result($cid, $cnam);
while ($stmt->fetch()) {
	echo '<option value='.$cid.'">'.$cnam.'</option>'.PHP_EOL;
}
?>
<input type="submit" name="add" value="Tilføj">

</form>
  


<?php
require_once 'dbcon.php';
$pnam = filter_input(INPUT_POST, 'navn');
$pdes  = filter_input(INPUT_POST, 'beskrivelse');
$pstart = filter_input(INPUT_POST, 'start');
$pslut = filter_input(INPUT_POST, 'slut');
$pdetaljer = filter_input(INPUT_POST, 'detaljer');




if (isset($_POST['add'])) {
$sql = 'INSERT INTO project (Project_ID, Name, Description, Start_Date, End_Date, Other_P_Detail, Client_Client_ID)
VALUES (null, ?, ?, ?, ?, ?, ?)';
$stmt = $link->prepare($sql);
$stmt->bind_param('sssssi', $pnam, $pdes, $pstart, $pslut, $pdetaljer, $cid);
$stmt->execute();
header ('Location: projectlist.php');
}
?>
<br><br>
<h3> Du kan ikke oprette et projektnavn, som er det samme som nedenstående: </h3>
<?php
require_once 'dbcon.php';

$sql = 'SELECT p.project_id, p.name FROM project p';
$stmt = $link->prepare($sql);
$stmt->execute();
$stmt->bind_result($pid, $pnam);

while($stmt->fetch()) {
	echo '<li><a href="project.php?pid='.$pid.'">'.$pnam.'</a></li>'.PHP_EOL;
}

?>

</body>
</html>