<?php

$config = json_decode(file_get_contents('./config.json'), true) or die("Can't find config.json");

$shortNamePlural = $config["app_settings"]["shortNamePlural"];


include "../includes/fields.php";


$reset = file_get_contents('./reset.json');
$dataFile = fopen("./data.json", "w") or die("Unable to open file!");
fwrite($dataFile, $reset);
fclose($dataFile);

echo "success!<br><br>";

$file = file_get_contents('./data.json');
$data = json_decode($file, FALSE);

echo "There are now " . count($data) . " $shortNamePlural";
echo "<br><br><a href=\"../list.php\">Go Back</a>";
