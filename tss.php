<h1>Tejas's Local Blob Server</h1>
<html>
<head>
<script type="text/javascript">
document.getElementById('board').style.visibility = 'hidden';
</script>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
/*shell_exec("tsschecker --save-path /home/pi/all_blobs --boardconfig n71ap -s -i 10.2 -e 340611353324 > /home/pi/all_blobs/debug.log 2>&1");
*/
if(isset($_POST['submit1'])) {
	$vedECID = $_POST[('files')];
	$liink = " <a href ='../all_blobs/";
	$liink .= $vedECID;
	$liink .= "'><h2>Blobs</h2></a>";
	echo $liink;
	//echo " <a href="all_blobs/">Click here</a>";

//	echo "   <a href=\\"">Link with your blobs!</a>";

	
}
if(isset($_POST['submit'])) {
    	$deviceIdentifier = $_POST[('deviceModel')];
	$deviceList = json_decode(file_get_contents('iPhone.json'), true);
	$deviceID =  $deviceList[$deviceIdentifier];
	$deviceECID = $_POST[('ECID')];
	$deviceBoard = $_POST[('boardconfig')];
	$boardList = json_decode(file_get_contents('board.json'), true);
	$devBoard = $boardList[$deviceBoard];
	$json = "http://api.ineal.me/tss/";
	$json .=  $deviceID;
	//echo $json;
	$jsonfile = file_get_contents($json);
	$devicesign = json_decode($jsonfile, true);
	$firmware = $devicesign[$deviceID]["firmwares"][0]["version"];
	//echo $firmware;
	shell_exec("mkdir ../all_blobs/".escapeshellarg($deviceECID));
			$cmd = "tsschecker";
			$cmd .= " -d ".escapeshellarg($deviceID);
			$cmd .= " -e ".escapeshellarg($deviceECID);
			$cmd .= " -i ".escapeshellarg($firmware);
			$cmd .= " -s ";
			if($deviceBoard != 0) {
				$cmd .= " --boardconfig ".escapeshellarg($devBoard);
			}
			$devvECID = str_replace('\'', '', $deviceECID);
			//echo $devvECID;
			$cmd .= " --save-path ../all_blobs/".escapeshellarg($devvECID);
			$cmd .= " > debug/debug.log 2>&1";
			//echo "Running: ".$cmd."\n";
			shell_exec($cmd);
			echo "Saved blobs for " .  $deviceID .  " with ECID " . $deviceECID . " for iOS " . $firmware;
			echo ". Here are your "; 
			$twolink = " <a href ='../all_blobs/";
        		$twolink .= $deviceECID;
        		$twolink .= "'><h2>Blobs</h2></a>";
        		echo $twolink;

}
?>

<div class="box">
			<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
			<p class="note">ECID(DEC) : </p>
			    <div class="inputGroup">
					<input type="text" name="ECID" placeholder="Type ECID Here..." style="width:85%">
				</div>
				<p class="note">Identifier : </p>
				<select id="deviceType" name="deviceType">
					<option value="iPhone">iPhone</option>
					<option value="iPod">iPod</option>
					<option value="iPad">iPad</option>
					<option value="AppleTV">AppleTV</option>
				</select>
				<select id="deviceModel" name="deviceModel">
					<option value="0">iPhone 2G</option>
					<option value="1">iPhone 3G</option>
					<option value="2">iPhone 3G[S]</option>
					<option value="3">iPhone 4 (GSM)</option>
					<option value="4">iPhone 4 (GSM 2012)</option>
					<option value="5">iPhone 4 (CDMA)</option>
					<option value="6">iPhone 4[S]</option>
					<option value="7">iPhone 5 (GSM)</option>
					<option value="8">iPhone 5 (Global)</option>
					<option value="9">iPhone 5c (GSM)</option>
					<option value="10">iPhone 5c (Global)</option>
					<option value="11">iPhone 5s (GSM)</option>
					<option value="12">iPhone 5s (Global)</option>
					<option value="13">iPhone 6+</option>
					<option value="14">iPhone 6</option>
					<option value="15">iPhone 6s</option>
					<option value="16">iPhone 6s+</option>
					<option value="17">iPhone SE</option>
					<option value="18">iPhone 7 (Global)</option>
					<option value="19">iPhone 7 Plus (Global)</option>
					<option value="20">iPhone 7 (GSM)</option>
					<option value="21">iPhone 7 Plus (GSM)</option>
				</select>
				<script type="text/javascript">

function yesnoCheck() {
    if (document.getElementById('deviceModel').value == "15") {
        document.getElementById('board').style.visibility = 'visible';
    } else {
        document.getElementById('board').style.visibility = 'hidden';
    }

</script>
				<div id="board">
				<p>ONLY IF iPhone 6S or 6S+</p>
				<select id="boardconfig" name = "boardconfig">
					<option value="0">Device is not an iPhone 6s or 6s+!</option>
					<option value="1">n71ap</option>
					<option value="2">n71map</option>
					<option value="3">n66ap</option>
					<option value="4">n66map</option>
				</div>
				<br><br>
				<input class="button" type="submit" value="Submit" name="submit">
				<p>Get the link to your saved blobs!</p> 
				<input type="text" name="files" placeholder="Type ECID Here..." style="width:85%">
				<input class="button" type="submit" value="Submit" name="submit1">

			</form>
		</div>
	
</body>
</html>
