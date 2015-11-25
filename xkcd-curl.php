<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>XKCD 1608 CURL</title>
<style>
body {
	text-align:center;
}
table {
	border-collapse:collapse;
}
td {
	border:1px solid #ccc;
}
</style>
</head>
<body>
<?

# Connect to Database
require_once('dbconnect.php');

# Start Time
$start = time();

# Center
$centerX = 1000;
$centerY = 1074;

# Min Max
$xMin = 928;
$xMax = 1107;

$yMin = 1069;
$yMax = 1112;

# CURL Count
$curl_count = 0;

# Start Table
echo '<table>' . "\n";

# Y VALUES // ROWS - Move down the page
for($y = $yMax; $y >= $yMin; $y--){

	# Start Row
	echo '<tr>' . "\n";
	
	# Row Label
	echo '<td style="font-weight:bold;">' . $y . '</td>' . "\n";
	
	# X VALUES // COLUMNS - Move Across Row
	for($x = $xMin; $x <= $xMax; $x++){
		
		# Image Path
		$image_src = 'http://xkcd.com/1608/' . $x . ':-' . $y . '+s.png';
		
		# Does Image Exist?
		# Check Table
		$exist_query = "SELECT exist FROM xkcd WHERE fileX='$x' AND fileY='$y'";
		$result = $mysqli->query($exist_query);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$exists = $row['exist'];
		
		# Image not in Database
		if($exists == ""){
			
			# CURL
			$ch = curl_init($image_src);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_exec($ch);
			$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			// $retcode >= 400 -> not found, $retcode = 200, found.
			curl_close($ch);
			$curl_count = $curl_count + 1;
			
			# Database Insert
			if($retcode == 200){
				$insert_query = "INSERT INTO xkcd (fileX, fileY, exist) VALUES ('$x', '$y', '1')";
				$exists = 1;
			}else{
				$insert_query = "INSERT INTO xkcd (fileX, fileY, exist) VALUES ('$x', '$y', '0')";
				$exists = 0;
			}
			$mysqli->query($insert_query);
			
		}
			
		# Output
		if($exists == 1){
			echo '<td>&bull;</td>' . "\n";
		}else{
			echo '<td>&nbsp;</td>' . "\n";
		}
	}
	
	# End Row
	echo '</tr>' . "\n";
	
}

# Bottom Row
echo '<td>&nbsp;</td>';	
for($x = $xMin; $x <= $xMax; $x++){
	echo '<td style="font-weight:bold;">' . $x . '</td>' . "\n";
}

# End Table
echo '</table>' . "\n";

# End time
$stop = time();
$duration = $stop - $start;

# Duration
echo '<p>Start: ' . date('g:i:s', $start) . '<br/>Finish: ' . date('g:i:s', $stop) . '<br/>Duration: ' . $duration . ' seconds<br/>CURL Count: ' . $curl_count . '</p>' . "\n";

?>
</body>
</html>
 
