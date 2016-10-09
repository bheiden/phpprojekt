<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>

<?php
$pid = filter_input(INPUT_GET, 'pid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');

require_once 'dbcon.php';
$sql = 'SELECT p.name, p.description, p.start_date, p.end_date, c.Client_ID, c.name FROM project p, client c
WHERE p.project_id = ?
AND c.client_id=p.client_client_id';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $pid);
$stmt->execute();
$stmt->bind_result($pnam, $pdesc, $pstart, $pend, $cid, $cnam);
?>
<ul>
<?php
while($stmt->fetch()) {
echo '<h1>'.$pnam.'</h1>';
echo '<li>'.$pdesc.'</li>';
echo '<li>'.$pstart.'</li>';
echo '<li>'.$pend.'</li>';
echo '<li>'.$cid.'</li>';
echo '<li><a href="http://benjaminheiden.dk/php3/client.php?cid='.$cid.'">'.$cnam.'</a></li>';
}
?>
</ul>
	
	
<?php
$sql = 'SELECT r.r_name, r.resource_id
FROM resource r, project p, resource_has_project rp
WHERE p.project_id = ?
AND p.project_id = rp. project_project_id
AND r.resource_id = rp.resource_resource_id';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $pid);
$stmt->execute();
$stmt->bind_result($rnam, $rid);
?>
<ul>
<?php
while($stmt->fetch()) {
echo '<h1>'.$rnam.'</h1>';
echo '<li>'.$rid.'</li>';
}
?>
</ul>
<form method="post">
ÆNDRE BESKRIVELSE
<input type="text" name="beskrivelse" required>
<?php 
require_once 'dbcon.php';
$pbe = filter_input(INPUT_POST, 'beskrivelse');

if (isset($_POST['ad'])) {
$sql = 'update project
	set description = ?
	where project_ID = ?';
$stmt = $link->prepare($sql);
$stmt->bind_param('si', $pbe, $pid);
$stmt->execute();
header ('Refresh:0');
}
?>

<input type="submit" name="ad" value="ændre det nu">
</form>
<br>
<button><a href="projectlist.php" style="text-decoration: none; color: black;">Tilbage til Projektmappen</a></button>
</body>
</html>