<?php

$config_lines = file('fake_config.txt');

$config_file_array = array();

for($i = 0; $i < count($config_lines); $i++){
	
	//Reset variables for next config line.
	$current_key = "";
	$current_value = "";
	$before_equals = 1;

	//Removes newlines
	if($config_lines[$i] == "\n"){
		array_splice($config_lines, $i, 1);
	}

	//sets up comment count so we can have unique key values to store comments
	if($i == 0){
		$comment_count = 1;
	}

	//ultimately populates the $config_file_array
	for($j = 0; $j < strlen($config_lines[$i]); $j++){
		
		//creates comment key value pairs
		if($j == 0 && $config_lines[$i][0] == "#"){
			$config_file_array["comment_$comment_count"] = $config_lines[$i];
			$comment_count++;
		}
		//creates key for array
		elseif($config_lines[$i][$j] != "=" && $before_equals == 1 && $config_lines[$i][0] != "#"){
			$current_key = $current_key . $config_lines[$i][$j];
		}
		//flips switch/boolean so we can start creating values
		elseif($config_lines[$i][$j] == "=" && $config_lines[$i][0] != "#") {
			$before_equals = 0;
		}
		//creates value for array
		elseif($before_equals == 0 && $config_lines[$i][$j] != "=" && $config_lines[$i][0] != "#"){
			$current_value = $current_value . $config_lines[$i][$j];

			//creates array once we have cycled through the config file line
			if($j == strlen($config_lines[$i])-1){
				$current_key = trim($current_key);
				$current_value = trim($current_value);
				$config_file_array[$current_key] = $current_value;
			}
		}
	}
}


//Fixes any datatype issues, eg: makes sure booleans are actually booleans and numbers are actually numbers.
foreach($config_file_array as $key => $value){
	
	//turns all string numbers into actual numbers.
	if(floatval($value) != 0){
		$config_file_array[$key] = floatval($value);
	}

	//if a config value is true or false, turn it into actual boolean in the array
	if($config_file_array[$key] == "true" || $config_file_array[$key] == "on" || $config_file_array[$key] == "yes"){
		$config_file_array[$key] = true;
	}
	elseif($config_file_array[$key] == "false" || $config_file_array[$key] == "off" || $config_file_array[$key] == "no"){
		$config_file_array[$key] = false;
	}
}

//The array in its entirety
var_dump($config_file_array);
echo "<br><br>";

//Lets access a comment
var_dump('comment_1');
echo "<br><br>";

//Lets access one of the numerical values
var_dump($config_file_array['server_id']);
echo "<br><br>";

//Lets access one of the string values:
var_dump($config_file_array['host']);
echo "<br><br>";

//Lets access one of the booleans:
var_dump($config_file_array['verbose']);
echo "<br><br>";

?>