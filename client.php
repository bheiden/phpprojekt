<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>

<?php
$cid = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');

require_once 'dbcon.php';
$sql = 'SELECT c.name, c.address, z.zip, z.City, c.contact_name, c.contact_phone, p.name, p.project_id
FROM project p, client c, zip z
WHERE c.client_id = ?
AND c.client_id=p.client_client_id
AND c.zip_zip=z.zip';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $cid);
$stmt->execute();
$stmt->bind_result($cnam, $cadd, $zzip, $zcity, $ccn, $ccp, $pnam, $pid);
?>
	
<?php
while($stmt->fetch()) {
echo '<h1>'.$cnam.'</h1>';
echo '<li>'.$cadd.'</li>';
echo '<li>'.$zzip.'</li>';
echo '<li>'.$zcity.'</li>';
echo '<li>'.$ccn.'</li>';
echo '<li>'.$ccp.'</li>';
echo '<li><a href="http://benjaminheiden.dk/php3/project.php?pid='.$pid.'">'.$pnam.'</a></li>';
}
?>

</body>
</html>