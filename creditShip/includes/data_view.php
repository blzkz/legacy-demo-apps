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

        if ($data->number === "") {
            echo "<form action=\"./update.php\" method=\"POST\">
                    <input type=\"hidden\" id=\"id\" name=\"id\" value=\"$newId\">
                    <input id=\"approve-$shortNameLower-$newId-button\" type=\"submit\" value=\"Approve\" name=\"approve\"/>
                </form><br /><br />";
        }

        break;
    }
}
