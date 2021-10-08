<?php
$file = file_get_contents('./data/data.json');
$claims = json_decode($file, FALSE);

//var_dump($claims);


echo '<form action="./claim.php">
    <input id="new-claim-button" type="submit" value="New Claim" />
</form><br /><br />';


foreach (array_reverse($claims) as $key => $claim) {
    echo '<a id="claim-link-' . $claim->claim . '" href="./claim.php?c=' . $claim->claim . '">Claim ' . ($claim->claim + 4020) . "<a/><br>";
    if ($key > 10)
        break;
}

echo '<br>---<br><br><a id="claim-link-list" href="./list.php">All Claims<a/><br>';