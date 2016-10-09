<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<?php
$fid = filter_input(INPUT_POST, 'fid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');
$cid = filter_input(INPUT_POST, 'cid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');

// echo $fid.' xxxx '.$cid;

require_once 'dbcon.php';
$sql = 'INSERT INTO film_category (category_id, film_id) VALUES (?, ?)';
$stmt = $link->prepare($sql);
$stmt->bind_param('ii', $cid, $fid);
$stmt->execute();

if($stmt->affected_rows > 0) {
	echo 'Film added to category :-)';
}
else {
	echo 'Film already in category';
}
?>

<a href="filmdetails.php?fid=<?=$fid?>">Se Film</a><br>
<a href="filmlist.php?cid=<?=$cid?>">Se film i samme kategori</a><br>



</body>
</html>