<?php
if(!file_exists("./data/data.json")){
  $reset = file_get_contents('./data/reset.json');
  $dataFile = fopen("./data/data.json", "w") or die("Unable to open file!");
  fwrite($dataFile, $reset);
  fclose($dataFile);
}
$applicationName = "Claims App";
?>
<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?= $applicationName ?></title>
  <meta name="description" content="A simple claims app from 2008 that's never, ever going to be maintained. Need help? Email the IT department!">
  <meta name="author" content="Jason Scanzoni - Appian Solutions Consultant">

</head>

<body>