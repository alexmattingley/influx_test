<p><?php echo "server working!"; ?></p>

<?php

$config_lines = file('fake_config.txt');

$number_of_lines = count($config_lines);


//Remove an newlines
for($i = 0; $i < $number_of_lines; $i++){
	if($config_lines[$i] == "\n"){
		array_splice($config_lines, $i, 1);
	}
}
//config_lines should be free of \n here.



?>