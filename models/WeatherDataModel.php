<?php

class WeatherDataModel {
	function __construct() {
		$this->date = date('dmy');
		$this->offsets = [
			"time" => 14,
			"tempsign" => 20,
			"temp" => 21,
			"dewpsign" => 25,
			"dewp" => 26,
			"stp" => 30,
			"slp" => 35,
			"visb" => 38,
			"wdsp" => 42,
			"prcp" => 45,
			"sndp" => 49,
			"frost" => 53,
			"rain" => 54,
			"hail" => 55,
			"thunder" => 56,
			"tornado" => 57 
		];
	}

	public function dump()
	{
		echo $this->date;
		$handle = fopen($this->filename, "r") or die ("unable to read file". $this->filename);
		if ($handle) {
			while(!feof($handle)) 
			{
				$dd = fgets($handle);
				$dataBlocks = explode(';', $dd);
				foreach ($dataBlocks as $dataBlock) {
					echo($dataBlock."<br>");
				}
			}	
		}
	}

	/**
	 * Vraag data van meerdere stations tegelijk op
	 * param: array
	 * returns: array
	 * */
	public function getMultipleStationData($stationIDs){
		if (gettype($stationIDs) != "array") return null;	// Return null if not array.
		$stationsData = [];
		foreach ($stationIDs as $stationID) {
			foreach ($this->getStationData($stationID) as $stationData) {
				array_push($stationsData, $stationData);
			}
		}
		return $stationsData;
	}

	/**
	 * Returned stationdata in JSON format
	 * @param integer $stationID 
	 * @return json
	 */
	public function getStationDataJson($stationID)
	{
		$data = $this->getStationData($stationID);
	}

	/**
	 * Returned station data op basis van station ID van de huidige file.
	**/
	public function getStationData($stationID) {
		$dataBlocks = $this->readfile($this->filename); 	// Datablocks in array.
		$stationData = [];	// Init stationdata array

		foreach ($dataBlocks as $dataBlock) {	// Loop over alle stationdata en filter alle stationdata met StationID
			//echo $dataBlock."<br>";
			if (strcmp(substr($dataBlock, 2, 6), $stationID) == 0)
			{
				array_push($stationData, $dataBlock);
			}
		}
		return $stationData;
	}

	private function readfile($filename) {
		$handle = fopen($filename, "r") or die ("Unable to open file" . $filename);		// Open file handle
		$dataBlocks = [];
		if ($handle) {
			while(!feof($handle)) 	// Terwijl het geen end of file is...
			{
				$dd = fgets($handle);	// Lees de file line for line.
				$dataBlocks = explode(';', $dd);	// Split op ;
			}
		}
		return $dataBlocks;
	}

	/**
	 * Returned een array van een datablock
	 * @param type $datablock 
	 * @return type
	 */
	public function interp($datablock){
		// Determine signbit values.
		$signbit = substr($datablock, 20, 1);
		$temp = substr($datablock, 21, 4);
		if ($signbit == "1")(int)$temp = -1 * abs((int)$temp);
		$signbit = substr($datablock, 25, 1);
		$dewp = substr($datablock, 26, 4);
		if ($signbit == "1")(int)$dewp = -1 * abs((int)$dewp);

		$dataArray = [
		"time" => (int)substr($datablock, 14, 6),
		"temp" => (int)$temp,
		
		"stp" => substr($datablock, 30, 5),
		"slp" => substr($datablock, 35, 5),
		"visb" => substr($datablock, 38, 4),
		"wdsp" => substr($datablock, 42, 3),
		"prcp" => substr($datablock, 45, 4),
		"sndp" => substr($datablock, 49, 4),
		"frost" => substr($datablock, 53, 1),
		"rain" => substr($datablock, 54, 1),
		"hail" => substr($datablock, 55, 1),
		"thunder" => substr($datablock, 56, 1),
		"tornado" => substr($datablock, 57, 1)
		];
		echo json_encode($dataArray);
	}
}

?>