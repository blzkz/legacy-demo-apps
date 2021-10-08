<?php
$claimNo = (isset($_GET['c']) ? $_GET['c'] : null); 

$file = file_get_contents('./data/data.json');
$claims = json_decode($file, FALSE);

$newClaimNo = (($claims[(count($claims) - 1)]->claim) + 1);

$claim = [
    "claim" => null,
    "reinsured" => "",
    "claimant" => "",
    "type" => "",
    "month" => "",
    "policy" => "",
    "location" => "",
    "totalLossToCover" => "",
    "totalPayableAmount" => "",
    "lineitems" => []
];

if (isset($_GET['n'])) {
    $lineitems = [];

    for ($i = 0; $i < (intval($_GET['n'])); $i++) {
        $lineitems[$i] = [];
    }

    $claim["lineitems"] = $lineitems;
}

if (isset($_POST["new-lineitem"])) {
    $lineitems = [];

    for ($i = 0; $i < (intval($_POST["numLines"]) + 1); $i++) {
        $lineitems[$i] = array(
            "dateOfLoss" => isset($_POST["dateOfLoss" . $i]) ? $_POST["dateOfLoss" . $i] : "",
            "description" => isset($_POST["description" . $i]) ? $_POST["description" . $i] : "",
            "incurred" => isset($_POST["incurred" . $i]) ? $_POST["incurred" . $i] : "",
            "paid" => isset($_POST["paid" . $i]) ? $_POST["paid" . $i] : "",
            "payable" => isset($_POST["payable" . $i]) ? $_POST["payable" . $i] : ""
        );
    }

    $claim = [
        "claim" => intval($_POST["claim"]),
        "reinsured" => $_POST["reinsured"],
        "claimant" => $_POST["claimant"],
        "type" => $_POST["type"],
        "month" => $_POST["month"],
        "policy" => $_POST["policy"],
        "location" => $_POST["location"],
        "totalLossToCover" => $_POST["totalLossToCover"],
        "totalPayableAmount" => $_POST["totalPayableAmount"],
        "lineitems" => $lineitems
    ];
}

if (isset($_POST["submit"])) {
    $lineitems = [];

    for ($i = 0; $i < (intval($_POST["numLines"])); $i++) {
        $lineitems[$i] = array(
            "dateOfLoss" => $_POST["dateOfLoss" . $i],
            "description" => $_POST["description" . $i],
            "incurred" => $_POST["incurred" . $i],
            "paid" => $_POST["paid" . $i],
            "payable" => $_POST["payable" . $i]
        );
    }

    $claim = [
        "claim" => intval($_POST["claim"]),
        "reinsured" => $_POST["reinsured"],
        "claimant" => $_POST["claimant"],
        "type" => $_POST["type"],
        "month" => $_POST["month"],
        "policy" => $_POST["policy"],
        "location" => $_POST["location"],
        "totalLossToCover" => $_POST["totalLossToCover"],
        "totalPayableAmount" => $_POST["totalPayableAmount"],
        "lineitems" => $lineitems
    ];

    $claims[$newClaimNo - 1] = $claim;

    echo "<div id=\"success\" style=\"background-color:green;color:white;text-align:center;width:100%;\">SUCCESS</div>";

    $dataFile = fopen("./data/data.json", "w") or die("Unable to open file!");
    fwrite($dataFile, json_encode($claims, JSON_PRETTY_PRINT));
    fclose($dataFile);

    $newClaimNo++;
    $claim = [
        "claim" => null,
        "reinsured" => "",
        "claimant" => "",
        "type" => "",
        "month" => "",
        "policy" => "",
        "location" => "",
        "totalLossToCover" => "",
        "totalPayableAmount" => "",
        "lineitems" => []
    ];
}


echo "<h2 style=\"text-align: center;\">New Claim #" . ($newClaimNo + 4020) . "</h2>";
echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"POST\">";
echo "<input type=\"hidden\" id=\"claim\" name=\"claim\" value=\"" . $newClaimNo . "\">";
echo "<h3>Claim Information</h3>";
echo "<table>";
echo "<tr><td style=\"padding:4px\"><strong><label for=\"reinsured\">Reinsured</label></strong></td><td id=\"field-reinsured\" style=\"padding:4px\"><input type=\"text\" id=\"reinsured\" name=\"reinsured\" value=\"" . $claim["reinsured"] . "\"></td></tr>";
echo "<tr><td style=\"padding:4px\"><strong><label for=\"claimant\">Claimant</label></strong></td><td id=\"field-claimant\" style=\"padding:4px\"><input type=\"text\" id=\"claimant\" name=\"claimant\" value=\"" . $claim["claimant"] . "\"></td></tr>";
echo "<tr><td style=\"padding:4px\"><strong><label for=\"type\">Type</label></strong></td><td id=\"field-type\" style=\"padding:4px\"><input type=\"text\" id=\"type\" name=\"type\" value=\"" . $claim["type"] . "\"></td></tr>";
echo "<tr><td style=\"padding:4px\"><strong><label for=\"month\">Month</label></strong></td><td id=\"field-month\" style=\"padding:4px\"><input type=\"text\" id=\"month\" name=\"month\" value=\"" . $claim["month"] . "\"></td></tr>";
echo "<tr><td style=\"padding:4px\"><strong><label for=\"policy\">Policy</label></strong></td><td id=\"field-policy\" style=\"padding:4px\"><input type=\"text\" id=\"policy\" name=\"policy\" value=\"" . $claim["policy"] . "\"></td></tr>";
echo "<tr><td style=\"padding:4px\"><strong><label for=\"location\">Location</label></strong></td><td id=\"field-location\" style=\"padding:4px\"><input type=\"text\" id=\"location\" name=\"location\" value=\"" . $claim["location"] . "\"></td></tr>";
echo "</table>";
echo "<h3>Items (" . count($claim["lineitems"]) . ")</h3>";
echo "<input type=\"hidden\" id=\"numLines\" name=\"numLines\" value=\"" . count($claim["lineitems"]) . "\">";
echo "<!--set number of lines as a GET variable using \"?n=" . count($claim["lineitems"]) . "\"-->";
echo "<table width=\"100%\" style=\"background-color:#f5f5f5; text-align:center;\"><tr><th>Date of Loss</th><th>Description</th><th>Incurred</th><th>Paid</th><th>Payable</th></tr>";
foreach ($claim["lineitems"] as $key => $line) {
?>
    <tr style="border: 1px solid #666666;">
        <td id="lineitem-<?= $key ?>-field-dateOfLoss"><input type="text" id="dateOfLoss<?= $key ?>" name="dateOfLoss<?= $key ?>" value="<?= $claim["lineitems"][$key]["dateOfLoss"] ?>"></td>
        <td id="lineitem-<?= $key ?>-field-description"><input type="text" id="description<?= $key ?>" name="description<?= $key ?>" value="<?= $claim["lineitems"][$key]["description"] ?>"></td>
        <td id="lineitem-<?= $key ?>-field-incurred"><input type="text" id="incurred<?= $key ?>" name="incurred<?= $key ?>" value="<?= $claim["lineitems"][$key]["incurred"] ?>"></td>
        <td id="lineitem-<?= $key ?>-field-paid"><input type="text" id="paid<?= $key ?>" name="paid<?= $key ?>" value="<?= $claim["lineitems"][$key]["paid"] ?>"></td>
        <td id="lineitem-<?= $key ?>-field-payable"><input type="text" id="payable<?= $key ?>" name="payable<?= $key ?>" value="<?= $claim["lineitems"][$key]["payable"] ?>"></td>
    </tr>
<?php
}
echo "<tr style=\"border: 1px solid #666666;\"><td colspan=\"5\"><input id=\"new-lineitem\" name=\"new-lineitem\" type=\"submit\" value=\"Add Line\" /></td><tr>";
echo "</table>";
echo "<h3>Totals</h3>";
echo "<table>";
echo "<tr><td id=\"field-totalLossToCover\" style=\"padding:4px\"><strong><label for=\"totalLossToCover\">Total Loss To Cover</label></strong></td><td  style=\"padding:4px\"><input type=\"text\" id=\"totalLossToCover\" name=\"totalLossToCover\" value=\"" . $claim["totalLossToCover"] . "\"></td></tr>";
echo "<tr><td id=\"field-totalPayableAmount\" style=\"padding:4px\"><strong><label for=\"totalPayableAmount\">Total Payable Amount</label></strong></td><td  style=\"padding:4px\"><input type=\"text\" id=\"totalPayableAmount\" name=\"totalPayableAmount\" value=\"" . $claim["totalPayableAmount"] . "\"></td></tr>";
echo "</table><br />";
echo "<div style=\"text-align:center;\"><input id=\"submit\" name=\"submit\" type=\"submit\" value=\"Submit\" /></div>";
echo "</form>"



?>