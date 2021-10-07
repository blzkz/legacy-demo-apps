Please hold...<br><br>Assigning credit card and processing shipment...

<?php

include "./includes/fields.php";

if (isset($_POST["approve"])) {
    $file = file_get_contents('./data/data.json');
    $data_list = json_decode($file, FALSE);

    foreach ($data_list as $key => $data) {
        if ($data->id == $_POST["id"]) {
            $data_list[$key]->number = $ccNumber;
            $data_list[$key]->exp = $expDate;
            $data_list[$key]->cvv = $cvv;
            $data_list[$key]->tracking = $tracking;
            $data_list[$key]->shipped = $shipped;
            $data_list[$key]->eta = $eta;

            $data_back = json_encode(
                array(
                    "requestId" => $_POST["id"],
                    "ccLastFour" => substr($ccNumber, -4),
                    "expiration" => $expDate,
                    "trackingNumber" => $tracking,
                    "shippedDate" => $shipped,
                    "etaDate" => $eta
                )
            );
        }
    }



    $dataFile = fopen("./data/data.json", "w") or die("Unable to open file!");
    fwrite($dataFile, json_encode($data_list, JSON_PRETTY_PRINT));
    fclose($dataFile);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$webhook");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "$apikey:");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_back);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    $output = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
 /*   echo $data_back."<br>";
    echo $output."<br>";
    var_dump($info);
*/
    echo "<script>
    setTimeout(function() {
    window.location.href = \"./view.php?i=" . $_POST["id"] . "\";}, 3000);
    </script>";
}

?>