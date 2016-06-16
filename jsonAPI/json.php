<?php
require './json-service.php';
$CIDS = ["m","i","c","h","u","a","s","j","x","e","z"];
$output = false;
setNewRecord('m', 1, 100, 2);
setNewRecord('i', 2, 100, 2);
setNewRecord('c', 3, 100, 2);

if (!empty($_GET['JSON'])) {
	if (!empty($_GET['JSON_CID'])) {
		$cid = $_GET['JSON_CID'];
		$exists = in_array($cid,$CIDS);
		if ($exists) $output = getRecords($cid);
	}
}

$output = ($output) ? $output : getRecords();
echo $output;
