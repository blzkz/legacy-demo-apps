<?php
$newId = $_GET['i'];


$file = file_get_contents('./data/data.json');
$data_list = json_decode($file, FALSE);


//var_dump($data_list);
echo "<h2 style=\"text-align: center;\">$recordName #" . ($newId) . "</h2>";
foreach (array_reverse($data_list) as $key => $data) {
    if ($data->id == $newId) {
        //var_dump($data);


        foreach ($fields["visible"] as $section => $items) {
            if ($section == "Line Items") {
                echo "<h3>" . $lineItemRecordNamePlural . " (" . count($data->lineitems) . ")</h3>";
                echo "<input type=\"hidden\" id=\"numLines\" name=\"numLines\" value=\"" . count($data->lineitems) . "\">";
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
                foreach ($data->lineitems as $key => $line) {
                    echo "<tr style=\"border: 1px solid #666666;\">";
                    foreach ($items as $field) {
                        echo "<td id=\"lineitem-$key-field-$field\">";
                        echo "<input type=\"text\" id=\"lineitem-$field" . $key . "\" name=\"lineitem-$field" . $key . "\" value=\"" . $line->$field . "\" disabled>";
                        echo "</td>";
                        echo "</th>";
                    }
                    echo "</tr>";
                }
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
                    echo "<td id=\"field-$field\" style=\"padding:4px\"><input type=\"text\" id=\"$field\" name=\"$field\" value=\"" . $data->$field . "\" disabled></td></tr>";
                }
                echo "</table><br />";
            }
            
        }
        if ($webhook_enabled & ($webhook_tetherField == "" | $data->$webhook_tetherField == "") ){
            echo "<form action=\"./update.php\" method=\"POST\">
                    <input type=\"hidden\" id=\"id\" name=\"id\" value=\"$newId\">
                    <input id=\"action-$shortNameLower-$newId-button\" type=\"submit\" value=\"".$webhook_actionDescription."\" name=\"action\"/>
                </form><br /><br />";
        }
        break;
    }
}
