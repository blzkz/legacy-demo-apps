
<?php

include "./includes/fields.php";

if (!$webhook_enabled)
    die("no webhook is enabled");

if (isset($_POST["action"])) {
    $file = file_get_contents('./data/data.json');
    $data_list = json_decode($file, FALSE);

    echo "Please hold...<br><br>$webhook_processPageDescription...";

    $index = null;

    foreach ($data_list as $key => $data) {
        if ($data->id == $_POST["id"]) {

            $data_back = json_encode($data);
            $index = $key;
            break;
        }
    }

    if (isset($index)) {


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$webhook_url");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$webhook_key:");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_back);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        foreach (json_decode($output) as $field => $value) {
            $data_list[$key]->$field = $value;
        }


        //var_dump($data_list);

        $dataFile = fopen("./data/data.json", "w") or die("Unable to open file!");
        fwrite($dataFile, json_encode($data_list, JSON_PRETTY_PRINT));
        fclose($dataFile);



        echo "<script>
            setTimeout(function() {
            window.location.href = \"./view.php?i=" . $_POST["id"] . "\";}, 3000);
            </script>";
    } else {
        echo "ERROR: ID " . $_POST["id"] . " NOT FOUND";
    }
}

?>