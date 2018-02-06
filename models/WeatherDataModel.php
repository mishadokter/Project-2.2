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
		$this->directory = "/mnt/sync/";
		$this->db = mysqli_connect("localhost", "jeroen", "1234HvP", "unwdmi") or die("At this moment, no valid database connection can be found. Please try again later!");
	}

	/**
	 * Request what stations have a higher than 80% dewpoint
	 * Parameter: string - country in question
	 * Returns: Array - Array of stations.
	 **/
	public function highDewPointStations($country) {
		$boundary = 80;		// Dauwpunt percentage.

		$sql = "SELECT stn FROM stations WHERE country = '$country'";

		$result = $this->db->query($sql);
		$stations = array();
		$historicDate = date('Y-m-d', strtotime(' -1 day'));
		$today = date('Y-m-d');
		while($row = $result->fetch_assoc()) {
			//TODO: optellen en delen door aantal ipv individuele metingen.
			if($this->getStationData($row['stn'], $historicDate, $today, 'humid') > $boundary){	// If the station has a higher than 80% relative humidity.
				array_push($stations, $row['stn']);
			}
		}
		var_dump($stations);
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

			$hour = -1;
			$total = 0;
			$count = 0;
			$skip = true;

		// Loop over alle files heen in de periode en interpreteer de datablocks naar een array.
		foreach ($period as $readDate) {
			$readDate = $readDate->format("Y-m-d");
			$dataArray = $this->readfile($readDate, $stationID);
			foreach ($dataArray as $dataBlock) {
				$temp = $this->interp($dataBlock);

				if($skip){
					$hour = (int)abs($temp[0]/10000);
					$skip = false;
				}
				if ($type == "humid"){		// Humidity exception
					$temperature = $temp[1];
					$dewp = $temp[2];

					$temp[1] = 100-5*($temperature - $dewp);
				}
				if((int)abs($temp[0]/10000) != $hour) {	// Deel op in blokken van een uur.
					$avg = $total / $count;
					array_push($requestedData[0], $hour.":00");
					array_push($requestedData[1], $total / $count);

					$hour = (int)abs($temp[0] / 10000);
					$count = 0;
					$total = 0;
				}
				else {
					if ($type=="humid")
						$total = $total + $temp[1];
					else
						$total = $total + $temp[$typeIndex];
					$count++;
				}
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
		$filename = $this->directory.$station."/".$filename.".dat";
		//$filename = $station."/".$filename.".dat"; // DEBUG
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