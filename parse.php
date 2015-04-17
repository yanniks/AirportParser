<?php
$csv = str_getcsv(file_get_contents("../depdata.csv"),"\n");
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
	$dataline = explode(";",$line);
	if (count($dataline) == 11) {
		if ($dataline["1"] == "DTW") {
			if (in_array($dataline[2],array_keys($data))) {
				$data[$dataline[2]] = $data[$dataline[2]] + $dataline[8];
			} else {
				$data[$dataline[2]] = $dataline[8];
			}
		}
	}
}
arsort($data);
foreach(array_keys($data) as $dat) {
	echo getname($json,$dat).": ".$data[$dat]."\n";
}