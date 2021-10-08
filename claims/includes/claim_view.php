<?php
$claimNo = $_GET['c'];


$file = file_get_contents('./data/data.json');
$claims = json_decode($file, FALSE);

//var_dump($claims);
echo "<h2 style=\"text-align: center;\">Claim #" . ($claimNo + 4020) . "</h2>";
foreach (array_reverse($claims) as $claim) {
    if ($claim->claim == $claimNo) {
        //var_dump($claim);
        echo "<h3>Claim Information</h3>";
        echo "<table>";
        echo "<tr><td style=\"padding:4px\"><strong>Reinsured</strong></td><td id=\"field-reinsured\" style=\"padding:4px\">" . $claim->reinsured . "</td></tr>";
        echo "<tr><td style=\"padding:4px\"><strong>Claimant</strong></td><td id=\"field-claimant\" style=\"padding:4px\">" . $claim->claimant . "</td></tr>";
        echo "<tr><td style=\"padding:4px\"><strong>Type</strong></td><td id=\"field-type\" style=\"padding:4px\">" . $claim->type . "</td></tr>";
        echo "<tr><td style=\"padding:4px\"><strong>Month</strong></td><td id=\"field-month\" style=\"padding:4px\">" . $claim->month . "</td></tr>";
        echo "<tr><td style=\"padding:4px\"><strong>Policy</strong></td><td id=\"field-policy\" style=\"padding:4px\">" . $claim->policy . "</td></tr>";
        echo "<tr><td style=\"padding:4px\"><strong>Location</strong></td><td id=\"field-location\" style=\"padding:4px\">" . $claim->location . "</td></tr>";
        echo "</table>";
        echo "<h3>Items (" . count($claim->lineitems) . ")</h3>";
        echo "<table width=\"100%\" style=\"background-color:#f5f5f5; text-align:center;\"><tr><th>Date of Loss</th><th>Description</th><th>Incurred</th><th>Paid</th><th>Payable</th></tr>";
        foreach ($claim->lineitems as $key => $line) {
?>
            <tr style="border: 1px solid #666666;">
                <td id="lineitem-<?= $key + 1 ?>-field-dateOfLoss"><?= $line->dateOfLoss ?></td>
                <td id="lineitem-<?= $key + 1 ?>-field-description"><?= $line->description ?></td>
                <td id="lineitem-<?= $key + 1 ?>-field-incurred"><?= $line->incurred ?></td>
                <td id="lineitem-<?= $key + 1 ?>-field-paid"><?= $line->paid ?></td>
                <td id="lineitem-<?= $key + 1 ?>-field-payable"><?= $line->payable ?></td>
            </tr>
<?php
        }
        echo "</table>";
        echo "<h3>Totals</h3>";
        echo "<table>";
        echo "<tr><td id=\"field-totalLossToCover\" style=\"padding:4px\"><strong>Total Loss To Cover</strong></td><td  style=\"padding:4px\">" . $claim->totalLossToCover . "</td></tr>";
        echo "<tr><td id=\"field-totalPayableAmount\" style=\"padding:4px\"><strong>Total Payable Amount</strong></td><td  style=\"padding:4px\">" . $claim->totalPayableAmount . "</td></tr>";
        echo "</table>";
        break;
    }
}


?>