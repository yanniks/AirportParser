<?php
$csv = str_getcsv(file_get_contents("../1996-2000 Departures.txt"),"\n");
$data = array();
$json = json_decode(file_get_contents("airports.json"),true);
function getname($json,$iata) {
	foreach($json as $airport) {
		if ($airport["iata"] == $iata) {
			if (empty($airport["name"])) {
				$name = $iata;
			} else {
				$name = $airport["name"];
			}
			return $name.", ".$airport["iso"];
		}
	}
	return $iata;
}
foreach($csv as $line) {
	$dataline = explode("#",$line);
	if (count($dataline) == 11) {
		if (strpos($dataline["1"],"DTW") !== false) {
			$dest = str_replace(" ","",$dataline[2]);
			if (in_array($dest,array_keys($data))) {
				$data[$dest] = $data[$dest] + $dataline[8];
			} else {
				$data[$dest] = $dataline[8];
			}
		}
	}
}
arsort($data);
foreach(array_keys($data) as $dat) {
	echo getname($json,$dat).": ".$data[$dat]."\n";
}