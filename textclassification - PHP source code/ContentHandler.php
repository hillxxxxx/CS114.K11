<?php
$class = 'Công nghệ';
$content = getContentFromTrainingFile("upload/".$class.".json");
$content = cleanSpecialCharacter($content);
$content = strtolower($content);
analysisTrainingContent($content, $class);

echo "<pre>";
var_dump($content);

function analysisTrainingContent($content, $class){
	$singleCharecter = array();
	$countEachCharacter = array();

	$singleCharecter = explode(' ', $content);
	$total = count($singleCharecter);
	$singleCharecter = array_unique($singleCharecter);

	foreach ($singleCharecter as $search) {
		$countEachCharacter[$search] = substr_count($content, $search);
	}


	$filename = "training/" . $class . ".json";

	unlink($filename);
	$classFile = fopen($filename, "w") or die("Unable to open file!");
	fwrite($classFile, json_encode($countEachCharacter, JSON_UNESCAPED_UNICODE));
	fclose($classFile);
}


function getContentFromTrainingFile($fileName) {
	$content = file_get_contents($fileName);
	$contentJson = json_decode($content, true);
	echo "<pre>";
	//var_dump($contentJson["Khoa học"]);
	$content = $contentJson[key($contentJson)];
	$content = strtolower($content);
	//echo $content;

	//remove stop word
	$myfile = fopen("upload/stopwordvietnamese.txt", "r") or die("Unable to open file!");
	$stopWordContent = array();
	// Output one line until end-of-file

	while(!feof($myfile)) {
	  $stopWordContent[] = fgets($myfile);
	}

	fclose($myfile);

	//var_dump($stopWordContent); 
	foreach ($stopWordContent as $stopWord) {
		$stopWord = trim(preg_replace('/\s\s+/', ' ', $stopWord));
		$content = str_replace(' '.$stopWord.' ', ' ', $content);
	}

	$content = cleanSpecialCharacter($content);

	return $content;
}

function cleanSpecialCharacter ($string){
	$string = str_replace("\n",' ', $string);
	$string = str_replace("\r",' ', $string);
	$string = str_replace('\'',' ', $string);
	$string = str_replace('`',' ', $string);
	$string = str_replace(':',' ', $string);
	$string = str_replace('.',' ', $string);
	$string = str_replace(',',' ', $string);
	$string = str_replace('?',' ', $string);
	$string = str_replace('(',' ', $string);
	$string = str_replace(')',' ', $string);
	$string = str_replace('{',' ', $string);
	$string = str_replace('-',' ', $string);
	$string = str_replace('|',' ', $string);
	$string = str_replace(';','', $string);
	$string = str_replace('/',' ', $string);
	$string = str_replace('\\',' ', $string);
	$string = str_replace("\"",'', $string);
	$string = str_replace("0",'', $string);
	$string = str_replace("1",'', $string);
	$string = str_replace("2",'', $string);
	$string = str_replace("3",'', $string);
	$string = str_replace("4",'', $string);
	$string = str_replace("5",'', $string);
	$string = str_replace("6",'', $string);
	$string = str_replace("7",'', $string);
	$string = str_replace("8",'', $string);
	$string = str_replace("9",'', $string);
	$string = str_replace("@",'', $string);
	$string = str_replace("$",'', $string);
	$string = str_replace("&",'', $string);
	$string = str_replace("%",'', $string);
	$string = str_replace("!",'', $string);
	$string = str_replace("  ",' ', $string);
	$string = str_replace("   ",' ', $string);
	return $string;
}
?>