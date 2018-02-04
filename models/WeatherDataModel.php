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
		// Deze array wordt gebruikt om de index te bepalen van de bovenstaande array.
		$this->typeIndexes = [
			"time",
			"temp",
			"dewp",
			"stp",
			"slp",
			"visb",
			"wdsp",
			"prcp",
			"sndp",
			"frost",
			"rain",
			"hail",
			"thunder",
			"tornado"
		];
		$this->directory = "/home/dutchsat/sync/data/";
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
	 * Returned station data op basis van station ID van de huidige file.
	**/
	public function getStationData($stationID, $fromdate, $todate, $type) {
			$typeIndex = array_search($type, $this->typeIndexes);	// vind de index van het gevraagde type variabele.

			$date1 = new DateTime($fromdate);
			$date2 = new DateTime($todate);

			$interval = DateInterval::createFromDateString('1 day');
			$period = new DatePeriod($date1, $interval, $date2);

			$dataBlocks = array();
			$requestedData = array([],[]);

		// Loop over alle files heen in de periode en interpreteer de datablocks naar een array.
		foreach ($period as $readDate) {
			$readDate = $readDate->format("Y-m-d");
			$dataArray = $this->readfile($readDate, $stationID);
			foreach ($dataArray as $dataBlock) {
				$temp = $this->interp($dataBlock);
				array_push($requestedData[0], $temp[0]);
				array_push($requestedData[1], $temp[$typeIndex]); 		// Push type variable to requested data.
			}
		}
		//var_dump($dataBlocks);
		// Index of $type in $data. bijv temp geeft temperatuur  als index.
		return $requestedData;
	}

	/**
	 * Open data file by filename and return it's datablocks
	**/
	private function readfile($filename, $station) {
		$dataBlocks = array();
		//$filename = $this->directory.$station."/".$filename.".dat";
		$filename = $station."/".$filename.".dat"; // DEBUG
		
		if(file_exists($filename))
		{
			$handle = fopen($filename, "r") or die ("Unable to open file" . $filename);		// Open file handle
			$dataBlocks = [];
			if ($handle) {
				while(!feof($handle)) 	// Terwijl het geen end of file is...
				{
					$dd = fgets($handle);	// Lees de file line for line.
					$dataBlocks = explode(';', $dd);	// Split op ;
				}
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
		return($dataArray);
	}
}

?>