<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Dragons of Mugloar</title>
</head>






<body>
<h1>......................Dragon of Mugloar Knight Attribute.........................</h1>
<?php 
	$jsdata = file_get_contents("http://www.dragonsofmugloar.com/api/game");
	$json = json_decode($jsdata, true);
	$gameId = $json['gameId'];
	echo 'Game Id :- '.$gameId.'<br>';
	echo 'Knight: <br>';
	echo 'Name :'.$json['knight']['name'].'<br>';
	echo 'Attack :'.$json['knight']['attack'].'<br>';
	echo 'Armor :'.$json['knight']['armor'].'<br>';
	echo 'Agility :'.$json['knight']['agility'].'<br>';
	echo 'Endurance :'.$json['knight']['endurance'].'<br><br>';
?>
<hr>
<?php

if(isset($gameId)){
$url = 'http://www.dragonsofmugloar.com/weather/api/report/'.$gameId;
$weather = simplexml_load_file($url);
echo'<h1>......................Weather Report From Royal Weather Service....................</h1>';
echo 'Game Id: '.$gameId.'<br>';
echo '<strong>Time</strong>:<br>'.$weather->time.'<br>';
echo '<strong>Coordinates</strong>:<br> X: '.$weather->coords->x.'<br>';
echo 'Y: '.$weather->coords->y.'<br>';
echo 'Z: '.$weather->coords->z.'<br>';
echo '<strong>Code</strong>:<br> '.$weather->code.'<br>';
echo '<strong>Message</strong>:<br>'.$weather->message.'<br>';
}

?>


<?php 
if($_SERVER["REQUEST_METHOD"]=="POST"){
	
// pick up the form data and write to JSON File 

	$scale=$_POST['scaleThickness'];
	$claw=$_POST['clawSharpness'];
	$wing=$_POST['wingStrength'];
	$breath=$_POST['fireBreath'];
	
$result = fopen("dragon/JSON.json","w");
fwrite($result, '{"dragon":{"scaleThickness":'.$scale.',"clawSharpness":'.$claw.',"wingStrenght":'.$wing.',"fireBreath":'.$breath.'}}');

fclose($result);

 function callRestAPI($uri, $dragon) {
      $headers = array (
         "Content-Type: application/json; charset=utf-8",
          "Content-Length: " .strlen($dragon)    
      );
      
      $channel = curl_init($uri);
      curl_setopt($channel, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($channel, CURLOPT_CUSTOMREQUEST, "PUT");
     curl_setopt($channel, CURLOPT_HTTPHEADER, $headers);
     curl_setopt($channel, CURLOPT_POSTFIELDS, $dragon);
     curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, false);
     curl_setopt($channel, CURLOPT_CONNECTTIMEOUT, 10);
     
     $status = curl_exec($channel);
     $statusCode = curl_getInfo($channel, CURLINFO_HTTP_CODE);
	 curl_close($channel);    
     return $status; 
	// return $statusCode;
 }

$jdata = file_get_contents("dragon/JSON.json");
$data = json_decode($jdata, true);
$data = json_encode($data, $option=0);
// Sample call
$resp = callRestAPI('http://www.dragonsofmugloar.com/api/game/'.$gameId.'/solution' , $data);
echo '<h3>Dragon Attribute</h3><br>'.($data).'<br>';
echo '<h3>Server Response</h3><br>';
echo $resp; 
//echo $statusCode;
$myfile = fopen("dragon/dragonlog.txt", "a") ;
fwrite($myfile, $resp.'\n');
//fwrite($myfile, $result);
fclose($myfile);                                                             

}
?>


<br><br>
<form action="" method="post">
ScaleThickness :<input type="number" max="10" min="0" name="scaleThickness"/><br><br>
ClawSharpness :<input type="number" max="10" min="0" name="clawSharpness"/><br><br>
WingStrenth :<input type="number" max="10" min="0" name="wingStrength"/><br><br>
FireBreath:<input type="number" max="10" min="0" name="fireBreath"/><br><br>
<button>Post Response</button>
</form></body>
</html>