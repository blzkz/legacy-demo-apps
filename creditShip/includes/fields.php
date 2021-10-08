<?php
$appname = "Credit Card Shipper";
$domain = "creditcardship.com";
$copyright = "2004";
$recordName = "Card Request";
$shortName = "Request";
$shortNameLower = strtolower($shortName);
$shortNamePlural = "Requests";

if (file_exists("./data/apicreds.json"))
    $creds = json_decode(file_get_contents('./data/apicreds.json'),true);
else
    $creds = ["url" => "", "key" => ""];

$webhook = $creds["url"];
$apikey = $creds["key"];

$fields = [
    "hidden" =>
    [
        "id"
    ],
    "visible" =>
    [
        "Customer Information" => [
            "fname",
            "lname",
            "street1",
            "street2",
            "city",
            "state",
            "zip"
        ],
        "Credit Card Information" => [
            "type",
            "number",
            "exp",
            "cvv"
        ],
        "Shipping Information" => [
            "tracking",
            "shipped",
            "eta"
        ]
    ]
];

$displayName = [
    "id" => "ID",
    "fname" => "First Name",
    "lname" => "Last Name",
    "street1" => "Street 1",
    "street2" => "Street 2",
    "number" => "Card Number",
    "exp" => "Expiration Date",
    "cvv" => "CVV",
    "tracking" => "Tracking Number",
    "shipped" => "Shipped Date",
    "eta" => "ETA"
];

$summaryFields = [
    "id",
    "fname",
    "lname",
    "type"
];

$data_back_sample = array(
    "requestId" => "4032",
    "ccLastFour" => "3242",
    "expiration" => "10/1/2026",
    "trackingNumber" => "023080u3290383420923409",
    "shippedDate" => "10/03/2021",
    "etaDate" => "10/06/2021"
);

$ccNumber = rand(1000,9999)."-".rand(1000,9999)."-".rand(1000,9999)."-".rand(1000,9999);
$expDate = date("m")."/".(date("Y")+5);
$cvv = rand(100,999);
$tracking = number_format(9374869903500000000000+rand(0,999999999),0,"","");
$shipped = date('m/d/y');
$eta = date('m/d/y',strtotime(date_create()->format('Y-m-d H:i:s'). ' + 4 days'));