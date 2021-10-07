<?php

include "./includes/fields.php";


if(isset($_POST["submit"])){
    $newcreds = ["url" => $_POST["url"], "key" => $_POST["key"]];

    $dataFile = fopen("./data/apicreds.json", "w") or die("Unable to open file!");
    fwrite($dataFile, json_encode($newcreds, JSON_UNESCAPED_SLASHES));
    fclose($dataFile);
}

if (file_exists("./data/apicreds.json"))
    $creds = json_decode(file_get_contents('./data/apicreds.json'),true);
else
    $creds = ["url" => "", "key" => ""];
?>
<form action="./apicredentials.php" method="POST">
    url: <input type="text" id="url" name="url" value="<?=$creds["url"]; ?>" size="100"><br />
    key: <input type="text" id="key" name="key" value="<?=$creds["key"]; ?>" size="100"><br />
    <button name="submit" id="submit">Submit</button>
</form><br><br>
<strong>Example Payload</strong>
<pre><?=json_encode($data_back_sample, JSON_UNESCAPED_SLASHES);?></pre>