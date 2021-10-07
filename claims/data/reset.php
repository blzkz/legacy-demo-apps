<?php

$reset = file_get_contents('./reset.json');
$dataFile = fopen("./data.json", "w") or die("Unable to open file!");
fwrite($dataFile, $reset);
fclose($dataFile);

echo "success!<br><br>";

$file = file_get_contents('./data.json');
$claims = json_decode($file, FALSE);

echo "There are now ".count($claims)." claims";
echo "<br><br><a href=\"../list.php\">Go Back</a>";