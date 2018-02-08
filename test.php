<?php

include 'models/WeatherDataModel.php';

$Weathermodel = new WeatherDataModel();
$data = $Weathermodel->dewPointOverview("africa");
$th = '';
$tb = '';
echo '<pre>' . var_export($data, true) . '</pre>';
$th = "<th>".$data[0][1]."</th>";
foreach ($data as $station => $dataArray) {
	foreach ($dataArray as $time => $value) {
		$tb += "<tr><td>".$station."</td>";
		$tb += "<td>".$value[1][0]."</td>";
		$tb += "</tr>";
	}
}
?>

<table>
	<caption>table title and/or explanatory text</caption>
	<thead>
		<tr>
			<th><?=$th;?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<?=$tb;?>
		</tr>
	</tbody>
</table>
