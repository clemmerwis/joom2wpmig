<?php 

require './vendor/autoload.php';

$test = "test";
// file_put_contents("output.txt", $test);
$file = file_get_contents("output.txt");
eval(\Psy\sh());
?>
