<?php
if(isset($argv[1]) && isset($argv[2]) && isset($argv[3]))
{
	$file = fopen($argv[1], "r") or exit("Unable to open file!");
	$json = json_decode(file_get_contents($argv[3]));
	if($json == null)
		die("Failed to decode json");
	$macarray = array();
	while(!feof($file))
	{
		$csvline = fgetcsv($file);
		if(isset($csvline[2]) && substr_count($csvline[2], ':') == 5) // totally legit way of checking if valid mac
		{
			// Add it to the JSON.
			array_push($macarray, $csvline[2]);
		}
	}
	fclose($file);

	$Master = $json->stations;
	$NewStation = new stdclass();
	$NewStation->name = $argv[2];
	$NewStation->mac = $macarray;
	array_push($Master, $NewStation);
	$json->stations = $Master;
	file_put_contents($argv[3], json_encode($json, JSON_PRETTY_PRINT));
}
else
{
	echo "Please give the CSV File first and then the station name then the output json file\n";
}