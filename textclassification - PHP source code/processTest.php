<?php
$class1 = "Công nghệ";
$class2 = "Pháp luật";

//get test content
$fileName = 'test/test.txt';
$testContent = getContentFromTestFile($fileName);
$testContent = strtolower($testContent);
$testContent = cleanSpecialCharacter($testContent);



//analysis test content
analysisTestContent($testContent);


function analysisTestContent($content){
	$content = strtolower($content);
	$singleCharecter = array();
	$countEachCharacter = array();

	$singleCharecter = explode(' ', $content);
	$total = count($singleCharecter);
	$singleCharecter = array_unique($singleCharecter);

	foreach ($singleCharecter as $search) {
		$countEachCharacter[$search] = substr_count($content, $search);
	}
	// Kí tự chưa lược bỏ
	$countEachCharacteroriginal = $countEachCharacter;
	
	var_dump(array_sum($countEachCharacterclass1));

	// những từ không có trong file merge sẽ bỏ đi
	$mergeContent = file_get_contents($fileName);
	$mergeContent = file_get_contents("training/merge.json");
	$mergeContentArr = json_decode($mergeContent, true);

	foreach ($countEachCharacter as $key => $value) {
		if(!$mergeContentArr[$key])
			unset($countEachCharacter[$key]);
	}

	$countEachCharacterclass1 = $countEachCharacter;
	$countEachCharacterclass2 = $countEachCharacter;

	//ratio

	$ratio = array_sum($countEachCharacter)/ array_sum($countEachCharacteroriginal);
	echo "<pre>";
	var_dump(array_sum($countEachCharacter));


	$class1 = "Công nghệ";
	$class2 = "Pháp luật";

	//calculate class1
	$contentClass1 = file_get_contents("training/". $class1 .".json");
	$contentClass1Arr = json_decode($contentClass1, true);
	$class1Percent = array_sum($contentClass1Arr) / array_sum($mergeContentArr);
	$lamda = 1;
	
	//get lamda class1
	$lamdaClass1 = file_get_contents("training/lamda". $class1 .".json");
	$lamdaClass1Arr = json_decode($lamdaClass1, true);


	foreach ($countEachCharacter as $key => $value) {
		$temp = $lamda;
		$t = pow($lamdaClass1Arr[$key], $value);
		$temp *= $t;
		if ($temp == 0) {
			$lamda = $lamda * pow(10,300) * $t;
		} else {	
			$lamda = $temp;
		}
		
		//$lamda = $lamda * pow($lamdaClass1Arr[$key], $value);	
	}

	$resultClass1 = $lamda * $class1Percent;

	//ratio1

	//foreach ($mergeContentArr as $key => $value){
		$contentClass1Arr[$key] = 0;
	//var_dump(array_sum($contentClass1Arr));
	//}	
	//var_dump(count($countEachCharacterclass1));
	//foreach ($countEachCharacterclass1 as $key => $value){
	//	if (!$contentClass1Arr[$key]) {
	//		unset($countEachCharacterclass1[$Key]);
	///	}	
	//}
	//var_dump(count($countEachCharacterclass1));
	//foreach ($countEachCharacterclass1 as $key => $value){
	//	$contentClass1Arr[$key] = $value;
	//}

	//$ratio1 = array_sum($contentClass1Arr);
	//var_dump(array_sum($countEachCharacterclass1));

	
	//calculate class2
	$contentClass2 = file_get_contents("training/". $class2 .".json");
	$contentClass2Arr = json_decode($contentClass2, true);
	$class2Percent = array_sum($contentClass2Arr) / array_sum($mergeContentArr);
	$lamda = 1;
	
	//get lamda class2
	$lamdaClass2 = file_get_contents("training/lamda". $class2 .".json");
	$lamdaClass2Arr = json_decode($lamdaClass2, true);


	foreach ($countEachCharacter as $key => $value) {
		$temp = $lamda;
		$t = pow($lamdaClass2Arr[$key], $value);
		$temp *= $t;
		if ($temp == 0) {
			$lamda = $lamda * pow(10,300) * $t;
		} else {	
			$lamda = $temp;
		}
		//$lamda = $lamda * pow($lamdaClass2Arr[$key], $value) * pow(10,300);	
	}

	$resultClass2 = $lamda * $class2Percent;
	

$result = ($resultClass1 > $resultClass2) ? $class1 : $class2;
	if ($ratio > 0.8) {
		echo "<h1>Đoạn văn bản thuộc lớp ". $result ."</h1><br>";
		echo "Khả năng thuộc lớp có sẵn với tỉ lệ ". round($ratio*100) . "%<br>";

		//tính xác xuất class 1
		$class1ResultPercent = $resultClass1 / ($resultClass1 + $resultClass2);
		//tính xác xuất class 2
		$class2ResultPercent = $resultClass2 / ($resultClass1 + $resultClass2);
		echo "Xác xuất Lớp $class1 ". $class1ResultPercent ."<br>";
		echo "Xác xuất Lớp $class2 ". $class2ResultPercent ."<br>";;

		echo "Có giá trị tỉ lệ thuận như sau: <br>";
		echo "-	Lớp $class1 : $resultClass1 <br>";
		echo "-	Lớp $class2 : $resultClass2 <br>";
	} else {
		echo "<h1>Đoạn văn bản thuộc không thuộc các lớp có sẵn!</h1><br>";
		echo "Khả năng thuộc lớp có sẵn với tỉ lệ ". round($ratio*100) . "%<br>";
		echo "Có thể thuộc lớp ". $result. "<br>";
		//tính xác xuất class 1
		$class1ResultPercent = $resultClass1 / ($resultClass1 + $resultClass2);
		//tính xác xuất class 2
		$class2ResultPercent = $resultClass2 / ($resultClass1 + $resultClass2);
		echo "Xác xuất Lớp $class1 ". $class1ResultPercent ."<br>";
		echo "Xác xuất Lớp $class2 ". $class2ResultPercent ."<br>";

		echo "Có giá trị tỉ lệ thuận như sau: <br>";
		echo "-	Lớp $class1 : $resultClass1 <br>";
		echo "-	Lớp $class2 : $resultClass2 <br>";
	}
	

	echo "<pre>";
	var_dump($countEachCharacter);
}


function getContentFromTestFile($fileName) {
	$content = file_get_contents($fileName);
	$content = strtolower($content);

	//remove stop word
	$myfile = fopen("upload/stopwordvietnamese.txt", "r") or die("Unable to open file!");
	$stopWordContent = array();
	// Output one line until end-of-file

	while(!feof($myfile)) {
	  $stopWordContent[] = fgets($myfile);
	}

	fclose($myfile);

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