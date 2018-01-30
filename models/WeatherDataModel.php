<?php

class WeatherDataModel {
	function __construct() {
		$this->date = date('dmy');
		$this->offsets = [
			"time" => [0, 6],
			"temp" => [7, 3],
			"dewp" => [11, 3],
			"stp" => [14, 5],
			"slp" => [19, 5],
			"visb" => [24, 4],
			"wdsp" => [28, 3],
			"prcp" => [31, 4],
			"sndp" => [35, 4],
			"frost" => [39, 1],
			"rain" => [40, 1],
			"hail" => [41, 1],
			"thunder" => [42, 1],
			"tornado" => [43, 1] 
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
		$dataArray = array();
		foreach ($this->offsets as $name => $offset) {
			if ($name == "temp" || $name == "dewp"){
				if (substr($datablock, $offset[0]-1, $offset[0]) == "-"){
					array_push($dataArray, (int)(-1 * abs((int)substr($datablock, $offset[0], $offset[1]))));
				}
				else
					array_push($dataArray, (int)(substr($datablock, $offset[0], $offset[1])));
			}else {
				array_push($dataArray, (int)(substr($datablock, $offset[0], $offset[1])));
			}

			

		}
		echo json_encode($dataArray);
	}
}

?>