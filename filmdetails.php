<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>

<?php
// filmdetails.php?fid=346
$fid = filter_input(INPUT_GET, 'fid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');

require_once 'dbcon.php';
$sql = 'SELECT f.title, f.release_year, f.description, f.length, l.name AS lang
FROM film f, language l
WHERE f.film_id=?
AND f.language_id=l.language_id';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $fid);
$stmt->execute();
$stmt->bind_result($ftitle, $fyear, $fdesc, $flength, $flang);

while($stmt->fetch()) { }
?>
<h1><?=$ftitle?> (<?=$fyear?>)</h1>
<p>
Language: <?=$flang?><br>
Length: <?=$flength?> minutes<br>
</p>
<p><?=$fdesc?></p>


<h2>Featured in categories</h2>
<ul>
<?php
require_once 'dbcon.php';

$sql = 'SELECT c.category_id, c.name
FROM film_category fc, category c
WHERE fc.film_id=?
AND fc.category_id=c.category_id';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $fid);
$stmt->execute();
$stmt->bind_result($cid, $cnam);

while($stmt->fetch()) {
	echo '<li><a href="filmlist.php?cid='.$cid.'">'.$cnam.'</a></li>';
}

?>
</ul>

<form action="addfilmtocategory.php" method="post">
	<input type="hidden" name="fid" value="<?=$fid?>">
	<select name="cid">
<?php
require_once 'dbcon.php';

$sql = 'SELECT c.category_id, c.name FROM category c';
$stmt = $link->prepare($sql);
$stmt->execute();
$stmt->bind_result($cid, $cnam);

while($stmt->fetch()) {
	echo '<option value="'.$cid.'">'.$cnam.'</option>'.PHP_EOL;
}
?>
 
    </select>
    <input type="submit" value="add">
</form>




<h2>Actors</h2>
<ul>
<?php
require_once 'dbcon.php';

$sql = 'SELECT a.actor_id, a.first_name, a.last_name
FROM film_actor fa, actor a
WHERE fa.film_id=?
AND fa.actor_id=a.actor_id';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $fid);
$stmt->execute();
$stmt->bind_result($aid, $afn, $aln);

while($stmt->fetch()) {
	echo '<li><a href="actordetails.php?aid='.$aid.'">'.$afn.' '.$aln.'</a></li>';
}

?>
</ul>

</body>
</html>