<p><?php echo "server working!"; ?></p>

<?php

$config_lines = file('fake_config.txt');

print_r($config_lines . "<br>");

$number_of_lines = count($config_lines);


for($i = 0; $i < $number_of_lines; $i++){
	//print_r($config_lines[$i] . "<br>");
	if($config_lines[$i] == "\n"){
		unset($config_lines[$i]);
	}
}
print_r($config_lines);

?>