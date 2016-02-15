<p><?php echo "server working!"; ?></p>

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

foreach($config_file_array as $key => $value){
	//removes whitespace or any other problematic characters.
	$config_file_array[$key] = trim($value); 
	//turns all string numbers into actual numbers.
	if(floatval($value) != 0){
		$config_file_array[$key] = floatval($value);
	}elseif($config_file_array[$key] == "true"){
		$config_file_array[$key] = true;
	}
}

print($config_file_array["verbose"]) . "<br>";

foreach($config_file_array as $key => $value){
	print gettype($value) . "<br>";
}

print_r($config_file_array);

?>