<?php
$file = file_get_contents('./data/data.json');
$claims = array_reverse(json_decode($file, FALSE));
unset($_POST);
if (!isset($_GET["s"]))
    $start = 1;
else
    $start = intval($_GET["s"]);

$end = $start + 9;
$total = count($claims);
$lastpage = false;

if ($total <= $end) {
    $end = $total;
    $lastpage = true;
}


?>


<table style="width:90%; margin-left:auto; margin-right:auto;">
    <tr>
        <td style="text-align: left;">
            <h2>Claims List</h2>
        </td>
        <td style="text-align: right;">
            <form action="./claim.php">
                <input id="new-claim-button" type="submit" value="New Claim" />
            </form>
        </td>
    </tr>
</table>
<br />
<table style="width:90%; border: 1px solid #666666; margin-left:auto; margin-right:auto;">
    <tr style="background-color: #999999; color: #FFFFFF;">
        <th>Claim</th>
        <th>Reinsured</th>
        <th>Policy</th>
        <th>Month</th>
    </tr>
    <?php
    for ($i = $start - 1; $i < $end; $i++) {
        if ($i % 2 == 0)
            $bg = "#FFFFFF";
        else
            $bg = "#F5F5F5";
    ?>
        <tr style="background-color: <?= $bg ?>">
            <td><a id="claim-link-<?= $claims[$i]->claim ?>" href="./claim.php?c=<?= $claims[$i]->claim ?>"><?= ($claims[$i]->claim + 4020) ?><a /></td>
            <td><?= $claims[$i]->reinsured ?></td>
            <td><?= $claims[$i]->policy ?></td>
            <td><?= $claims[$i]->month ?></td>
        </tr>
    <?php
    }
    echo "</table>";
    echo "<br><br>";
    echo "$start - $end of $total<br><br>";

    if (!$lastpage)
        echo "<a href=\"list.php?s=" . ($end + 1) . "\">Next Page</a><br>";
    if ($start != 1)
        echo "<a href=\"list.php?s=" . max($start - 10, 1) . "\">Previous Page</a><br>";
