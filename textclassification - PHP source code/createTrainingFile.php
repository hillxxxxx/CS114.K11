<?php
$myfile = fopen("upload/data12.json", "r") or die("Unable to open file!");
$content = array();

// Output one line until end-of-file
while(!feof($myfile)) {
  $jsonLineStr = fgets($myfile);
  $jsonLineStr = substr($jsonLineStr, 0, -2);
  $jsonData = json_decode($jsonLineStr);
  //echo $jsonLineStr. '<br>';
  //echo $jsonData->theme. '<br>';

  if($jsonData->theme == 'Công nghệ') {
	$content[$jsonData->theme] = empty($content[$jsonData->theme]) ? implode("|", $jsonData->content) : $content[$jsonData->theme] . '|'. implode("|", $jsonData->content);  
	//echo $jsonData->theme.'<br>';
  }
}

fclose($myfile);
//echo $jsonLineStr;
echo "<pre>";
var_dump($content);
$newFile = 'upload/'. key($content) . '.json';
unlink($newFile);
$myfile = fopen($newFile, "w") or die("Unable to open file!");
fwrite($myfile, json_encode($content, JSON_UNESCAPED_UNICODE));
fclose($myfile);
?>