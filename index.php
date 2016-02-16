<?php

$config_lines = file('fake_config.txt');

$config_file_array = array();

for($i = 0; $i < count($config_lines); $i++){
	$current_key = "";
	$current_value = "";
	$before_equals = 1;

	//Remove newlines
	if($config_lines[$i] == "\n"){
		array_splice($config_lines, $i, 1);
	}

	//sets up comment count so we can have unique key values to store comments
	if($i == 0){
		$comment_count = 1;
	}


	for($j = 0; $j < strlen($config_lines[$i]); $j++){
		
		if($j == 0 && $config_lines[$i][0] == "#"){
			$config_file_array["comment_$comment_count"] = $config_lines[$i];
			$comment_count++;
		}elseif($config_lines[$i][$j] != "=" && $before_equals == 1 && $config_lines[$i][0] != "#"){
			$current_key = $current_key . $config_lines[$i][$j];
		}elseif($config_lines[$i][$j] == "=" && $config_lines[$i][0] != "#") {
			$before_equals = 0;
		}elseif($before_equals == 0 && $config_lines[$i][$j] != "=" && $config_lines[$i][0] != "#"){
			$current_value = $current_value . $config_lines[$i][$j];
			if($j == strlen($config_lines[$i])-1){
				$config_file_array[$current_key] = $current_value;
			}
		}
	}
}

var_dump($config_file_array);

print "<br>";

foreach($config_file_array as $key => $value){

	//creates keys that are free of whitespace so they are easier to access.
	$trimmed_key = trim($key);
	$config_file_array[$trimmed_key] = $config_file_array[$key];
	if($key != $trimmed_key){
		echo "this is working";
		unset($config_file_array[$key]);
	}

	//removes whitespace or any other problematic characters from values.
	$config_file_array[$key] = trim($value); 
	
	//turns all string numbers into actual numbers.
	if(floatval($value) != 0){
		$config_file_array[$key] = floatval($value);
	}
	//if a config value is true or false, turn it into actual boolean in the array
	if($config_file_array[$key] == "true"){
		$config_file_array[$key] = true;
	}
	elseif($config_file_array[$key] == "false"){
		$config_file_array[$key] = false;
	}
}

var_dump($config_file_array);

?>