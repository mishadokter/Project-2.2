<?php

class WeatherDataModel {
	function __construct($filename) {
		$this->filename = $filename;
	}

	public function dump()
	{
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
}

?>