<?php
$class1 = "Công nghệ";
$class2 = "Pháp luật";

//class1
$contentClass1 = file_get_contents("training/". $class1 .".json");
$contentClass1Arr = json_decode($contentClass1, true);

//class2
$contentClass2 = file_get_contents("training/". $class2 .".json");
$contentClass2Arr = json_decode($contentClass2, true);

$mergeArray = $contentClass1Arr;

foreach ($contentClass2Arr as $key => $value) {
	if($mergeArray[$key]) {
		$mergeArray[$key] += $value;
	} else {
		$mergeArray[$key] = $value;
	}
}

$totalD = count($mergeArray);
$totalNClass1 = array_sum($contentClass1Arr);
$totalNClass2 = array_sum($contentClass2Arr);

//calculate lamda class 1
$lamdaClass1 = array();

foreach ($mergeArray as $key => $value) {
	$lamdaClass1[$key] = ($contentClass1Arr[$key] + 1)/ ($totalD + $totalNClass1);
}

//save lamda file class 1
$filename = "training/lamda" . $class1 . ".json";

unlink($filename);
$classFile = fopen($filename, "w") or die("Unable to open file!");
fwrite($classFile, json_encode($lamdaClass1, JSON_UNESCAPED_UNICODE));
fclose($classFile);


//calculate lamda class 2
$lamdaClass2 = array();

foreach ($mergeArray as $key => $value) {
	$lamdaClass2[$key] = ($contentClass2Arr[$key] + 1)/ ($totalD + $totalNClass2);
}

//save lamda file class 2
$filename2 = "training/lamda" . $class2 . ".json";

unlink($filename2);
$classFile2 = fopen($filename2, "w") or die("Unable to open file!");
fwrite($classFile2, json_encode($lamdaClass2, JSON_UNESCAPED_UNICODE));
fclose($classFile2);

//save file merge
$filename3 = "training/merge.json";

unlink($filename3);
$classFile3 = fopen($filename3, "w") or die("Unable to open file!");
fwrite($classFile3, json_encode($mergeArray, JSON_UNESCAPED_UNICODE));
fclose($classFile3);

echo "<pre>";
//var_dump($totalD . ' - '. $totalNClass1. ' - '. $totalNClass2);
//var_dump($lamdaClass2);
?>