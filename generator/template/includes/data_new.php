<?php
include "./includes/fields.php";

$dataNo = (isset($_GET['i']) ? $_GET['i'] : null);

$file = file_get_contents('./data/data.json');
$data_list = json_decode($file, FALSE);

$newId = (($data_list[(count($data_list) - 1)]->id) + 1);

$data = [];

$numLines = isset($_POST["numLines"]) ? intval($_POST["numLines"]) : 0;

if(isset($_POST['new-lineitem'])){
    $numLines ++;
}

foreach ($fields["hidden"] as $field) {
    $data[$field] = isset($_POST[$field]) ? $_POST[$field] : "";
}

foreach ($fields["visible"] as $section => $items) {
    if ($section == "Line Items") {
        $data["lineitems"] = [];
        for ($i = 0; $i < $numLines; $i++) {
            foreach ($items as $field) {
                $data["lineitems"][$i][$field] = isset($_POST["lineitem-$field" . $i]) ? $_POST["lineitem-$field" . $i] : "";
            }
        }
    } else {
        foreach ($items as $field) {
            $data[$field] = isset($_POST[$field]) ? $_POST[$field] : "";
        }
    }
}

$data["id"] = $newId;



if (isset($_POST["submit"])) {

    foreach ($fields["hidden"] as $field) {
        if ($field == "id")
            $_POST[$field] = intval($_POST[$field]);

        $data[$field] = $_POST[$field];
    }

    foreach ($fields["hidden"] as $field) {
        if ($field == "id")
            $_POST[$field] = intval($_POST[$field]);

        $data[$field] = isset($_POST[$field]) ? $_POST[$field] : "";
    }

    foreach ($fields["visible"] as $section => $items) {
        if ($section == "Line Items") {
            $data["lineitems"] = [];
            for ($i = 0; $i < $numLines; $i++) {
                foreach ($items as $field) {
                    $data["lineitems"][$i][$field] = isset($_POST["lineitem-$field" . $i]) ? $_POST["lineitem-$field" . $i] : "";
                }
            }
        } else {
            foreach ($items as $field) {
                $data[$field] = isset($_POST[$field]) ? $_POST[$field] : "";
            }
        }
    }
    

    $data_list[] = $data;

    echo "<div id=\"success\" style=\"background-color:green;color:white;text-align:center;width:100%;\">SUCCESS</div>";

    $dataFile = fopen("./data/data.json", "w") or die("Unable to open file!");
    fwrite($dataFile, json_encode($data_list, JSON_PRETTY_PRINT));
    fclose($dataFile);

    $newId++;

    foreach ($fields["hidden"] as $field) {
        $data[$field] = null;
    }

    foreach ($fields["visible"] as $section => $items) {
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
foreach ($fields["visible"] as $section => $items) {
    if ($section == "Line Items") {
        echo "<h3>" . $lineItemRecordNamePlural . " (" . count($data["lineitems"]) . ")</h3>";
        echo "<input type=\"hidden\" id=\"numLines\" name=\"numLines\" value=\"" . count($data["lineitems"]) . "\">";
        echo "<!--set number of lines as a GET variable using \"?n=" . count($data["lineitems"]) . "\"-->";
        echo "<table width=\"100%\" style=\"background-color:#f5f5f5; text-align:center;\"><tr>";
        foreach ($items as $field) {
            echo "<th>";
            if (isset($displayName[$field]))
                echo $displayName[$field];
            else
                echo ucwords($field);
            echo "</th>";
        }
        echo "</tr>";
        foreach ($data["lineitems"] as $key => $line) {
            echo "<tr style=\"border: 1px solid #666666;\">";
            foreach ($items as $field) {
                echo "<td id=\"lineitem-$key-field-$field\">";
                echo "<input type=\"text\" id=\"lineitem-$field" . $key . "\" name=\"lineitem-$field" . $key . "\" value=\"" . $data["lineitems"][$key][$field] . "\">";
                echo "</td>";
                echo "</th>";
            }
            echo "</tr>";
        }
        echo "<tr style=\"border: 1px solid #666666;\"><td colspan=\"5\"><input id=\"new-lineitem\" name=\"new-lineitem\" type=\"submit\" value=\"Add $lineItemRecordName\" /></td><tr>";
        echo "</table>";
    } else {
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
}
echo "<div style=\"text-align:center;\"><input id=\"submit\" name=\"submit\" type=\"submit\" value=\"Submit\" /></div>";
echo "</form>";
