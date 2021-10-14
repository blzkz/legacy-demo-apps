<?php
if (file_exists("./data/config.json"))
    $config = json_decode(file_get_contents('./data/config.json'), true);
else
    die("Can't find config.json");

$appname = $config["app_settings"]["appname"];
$domain = $config["app_settings"]["domain"];
$copyright = $config["app_settings"]["copyright"];
$recordName = $config["app_settings"]["recordName"];
$shortName = $config["app_settings"]["shortName"];
$shortNameLower = strtolower($shortName);
$shortNamePlural = $config["app_settings"]["shortNamePlural"];
$lineItemRecordName = $config["app_settings"]["lineItemRecordName"];
$lineItemRecordNamePlural = $config["app_settings"]["lineItemRecordNamePlural"];

$fields = $config["fields"];

$displayName = $config["friendlyFieldNameOverrides"];

$summaryFields = $config["summaryFields"];


$webhook_enabled = strlen($config["app_settings"]["webhook"]["key"]) > 1 ? true : false;
$webhook_url = $config["app_settings"]["webhook"]["url"];
$webhook_key = $config["app_settings"]["webhook"]["key"];
$webhook_tetherField = $config["app_settings"]["webhook"]["enabledWhenBlankTetherField"];
$webhook_actionDescription = $config["app_settings"]["webhook"]["actionDescription"];
$webhook_processPageDescription = $config["app_settings"]["webhook"]["processPageDescription"];