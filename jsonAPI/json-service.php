<?php
/**
 * JSON API
 * This is supposed to enable people from polling out
 * without having to connect to the database every time
 *
 * @MoshMage
 */

/**
 * Returns whole records.json as a object(stdClass)
 * @param bool $outputJson
 * @return Object|string
 */
function getRecordFile($outputJson=false) {
	$string = file_get_contents('./records.json');
  if (!$string) $string = new stdClass();
  return ($outputJson) ? $string : json_decode($string);
}

/**
 * Converts new record to JSON and
 * glues it on the supposed json file
 *
 * @method setNewRecord
 * @param $cid
 * @param $itemid
 * @param $itemcost
 * @param $itemleft
 */
function setNewRecord($cid, $itemid, $itemcost, $itemleft) {
	$tmp_array = getRecordFile();
	$tmp_array->$cid->$itemid->cost = $itemcost;
	$tmp_array->$cid->$itemid->left = $itemleft;
	file_put_contents('./records.json',json_encode($tmp_array),LOCK_EX);
}

/**
 * @param string $cid
 * @return Object|string
 */
function getRecords($cid='all') {
	if ($cid === 'all') {
		return getRecordFile(true);
	} else {
		$tmp_array = getRecordFile();
    $specific = new stdClass();
    $specific->$cid = $tmp_array->$cid;
		return json_encode($specific);
	}
}
