<p><?php echo "server working!"; ?></p>

<?php

$config_lines = file('fake_config.txt');

$config_file_array = array();

for($i = 0; $i < count($config_lines); $i++){
	$current_key = "";
	$current_value = "";
	$before_equals = true;

	//Remove newlines
	if($config_lines[$i] == "\n"){
		array_splice($config_lines, $i, 1);
	}

	if($i == 0){
		$comment_count = 1;
	}

	for($j = 0; $j < strlen($config_lines[$i]); $j++){
		if($j == 0 && $config_lines[$i][0] == "#"){
			$config_file_array["comment $comment_count"] = $config_lines[$i];
			$comment_count++;
		}elseif($j!= "=" && $before_equals == true && $config_lines[$i][0] != "#"){
			$current_key = $current_key . $config_lines[$i][$j];
			echo "$current_key <br>";
		}elseif($j == "=" && $config_lines[$i][0] != "#") {
			$before_equals = false;
		}elseif($before_equals == false && $j != "=" && $config_lines[$i][0] != "#"){
			$current_value = $current_value . $config_lines[$i][$j];
			echo "$current_value <br>";
		}
	}
}


print_r($config_lines);
echo "<br>";
print_r($config_file_array);



?>