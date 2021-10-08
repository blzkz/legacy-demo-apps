<?php
include "./includes/fields.php";

$dataNo = (isset($_GET['i']) ? $_GET['i'] : null);

$file = file_get_contents('./data/data.json');
$data_list = json_decode($file, FALSE);

$newId = (($data_list[(count($data_list) - 1)]->id) + 1);

$data = [];

foreach ($fields["hidden"] as $field) {
    $data[$field] = null;
}

foreach ($fields["visible"] as $section=>$items) {
    foreach ($items as $field) {
        $data[$field] = null;
    }
}

$data["id"] = $newId;

if (isset($_POST["submit"])) {

    foreach ($fields["hidden"] as $field) {
        if ($field == "id")
            $_POST[$field] = intval($_POST[$field]);

        $data[$field] = $_POST[$field];
    }

    foreach ($fields["visible"] as $section=>$items) {
        foreach ($items as $field) {
            $data[$field] = $_POST[$field];
        }
    }

    $data_list[]=$data;

    echo "<div id=\"success\" style=\"background-color:green;color:white;text-align:center;width:100%;\">SUCCESS</div>";

    $dataFile = fopen("./data/data.json", "w") or die("Unable to open file!");
    fwrite($dataFile, json_encode($data_list, JSON_PRETTY_PRINT));
    fclose($dataFile);

    $newId++;

    foreach ($fields["hidden"] as $field) {
        $data[$field] = null;
    }

    foreach ($fields["visible"] as $section=>$items) {
        foreach ($items as $field) {
            $data[$field] = null;
        }
    }

    $data["id"] = $newId;
}


echo "<h2 style=\"text-align: center;\">New $recordName #" . ($newId) . "</h2>";
echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"POST\">";
foreach ($fields["hidden"] as $field) {
    echo "<input type=\"hidden\" id=\"$field\" name=\"$field\" value=\"" . $data[$field] . "\">";
}
foreach ($fields["visible"] as $section=>$items) {
    echo "<h3>$section</h3>";
    echo "<table>";
    foreach ($items as $field) {
        echo "<tr><td style=\"padding:4px\"><strong><label for=\"$field\">";
        if (isset($displayName[$field]))
            echo $displayName[$field];
        else
            echo ucwords($field);
        echo "</label></strong></td>";
        echo "<td id=\"field-$field\" style=\"padding:4px\"><input type=\"text\" id=\"$field\" name=\"$field\" value=\"" . $data[$field] . "\"></td></tr>";
    }
    echo "</table><br />";
}
echo "<div style=\"text-align:center;\"><input id=\"submit\" name=\"submit\" type=\"submit\" value=\"Submit\" /></div>";
echo "</form>";
