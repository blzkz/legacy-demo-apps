<?php
include("functions.php");
$count = 0;
$data = null;
$app_folder = null;

if (isset($_POST['app_folder']))
    $app_folder = strtolower(str_replace(" ", "_", $_POST['app_folder']));


if (!isset($_POST['config']))
    $config = file_get_contents('./template/data/config.json');
else
    $config = $_POST['config'];


if (isset($_POST['update']))
    unset($_POST['data']);


$settings = json_decode($config, true);

$sample = [];

$numLines = isset($_POST["numLines"]) ? intval($_POST["numLines"]) : 0;

if (isset($_POST['new-lineitem'])) {
    $numLines++;
}

foreach ($settings["fields"]["hidden"] as $field) {
    $sample[$field] = isset($_POST[$field]) ? $_POST[$field] : "";
}

foreach ($settings["fields"]["visible"] as $section => $items) {
    if ($section == "Line Items") {
        $sample["lineitems"] = [];
        for ($i = 0; $i < $numLines; $i++) {
            foreach ($items as $field) {
                $sample["lineitems"][$i][$field] = isset($_POST["lineitem-$field" . $i]) ? $_POST["lineitem-$field" . $i] : "";
            }
        }
    } else {
        foreach ($items as $field) {
            $sample[$field] = isset($_POST[$field]) ? $_POST[$field] : "";
        }
    }
}

if (isset($_POST['firstData']) && !isset($_POST["new-lineitem"])) {
    $settings = json_decode($config, true);


    $data[0] = $sample;

    unset($_POST['firstData']);
    $count = 1;
}

if (isset($_POST['publish'])) {
    $newFolderName = getcwd() . "/../app_" . $app_folder;

    if (is_dir($newFolderName))
        die("folder already exists");

    recurse_copy(getcwd() . "/template", $newFolderName);

    $resetFile = fopen($newFolderName . "/data/reset.json", "w") or die("Unable to open file!");
    fwrite($resetFile, $_POST["data"]);
    fclose($resetFile);

    $dataFile = fopen($newFolderName . "/data/data.json", "w") or die("Unable to open file!");
    fwrite($dataFile, $_POST["data"]);
    fclose($dataFile);

    $configFile = fopen($newFolderName . "/data/config.json", "w") or die("Unable to open file!");
    fwrite($configFile, $_POST["config"]);
    fclose($configFile);

    header("Location: /app_$app_folder/");
}

?>
<h1>Generate a Custom Legacy App</h1>
<span>Note: this wasn't made in Appian, and there was only a very minimal level of effort spent on this UX!</span><br>
<ol>
    <li>Give it a name</li>
    <li>Update config.json</li>
    <li>Generate data.json by using the form</li>
    <li>Update data.json further if you prefer</li>
    <li>Publish!</li>
</ol>
<strong>PRO TIP:</strong> <a href="https://jsonformatter.org/" target="_blank">JSON Formatter</a> may be helpful!<br><br>
<hr>
<form action="index.php" method="POST">
    <div style="margin-left: 40px; background-color:#f5f5f5; width:500px; padding: 10px;"><br>
        <table style="vertical-align:top; width:100%">
            <tr>
                <td style="vertical-align:top;">
                    <strong>1. App Folder Name:&nbsp;</strong>
                </td>
                <td style="vertical-align:top; text-align:right;">
                    <input type="text" name="app_folder" id="app_folder" value="<?= $app_folder; ?>" size="45">
                    <?php
                    if (strlen($app_folder) > 1) {
                        $newFolderName = getcwd() . "/../app_" . $app_folder;

                        if (is_dir($newFolderName))
                            echo "<br><small style=\"color: #f44336;\"><strong>Folder &quot;$app_folder&quot; already exists</strong></small>";
                    }
                    ?>
                    <br>
                    <small>Please use a <strong>unique</strong> name and don't use spaces.</small>

                    <br><br>
                    <div style="text-align:right"><button name="publish" <?= ($count < 1 ? "disabled" : "style=\"background-color: #008CBA; color:#FFFFFF;\""); ?>>5. Publish App</button></div>
                </td>
            </tr>
        </table><br>
    </div>
    <hr><br>
    <table>
        <tr>
            <td style="width: 50%; vertical-align:top;">
                <h2>
                    2. config.json
                </h2>
                <button name="update" <?= ($count < 1 ? "" : "style=\"background-color: #f44336; color:#FFFFFF;\""); ?>><?= ($count < 1 ? "Update Form" : "Reset Data Structure, Clear data.json, and Fill In Form Again"); ?></button><br><br>
                <small>(<a href="https://restfulapi.net/json-syntax/" target="_blank">JSON Syntax Refresher</a>)</small><br>
                <textarea name="config" id="config" cols="75" rows="40"><?= $config; ?></textarea>
                <div style="width: 600px;"><small>
                        <ul>
                            <li><strong>app_settings</strong>
                                <ul>
                                    <li style="margin-bottom: 6px;"><strong>appname: </strong>Application header</li>
                                    <li style="margin-bottom: 6px;"><strong>domain: </strong>Shows up in the fake email address in the footer</li>
                                    <li style="margin-bottom: 6px;"><strong>copyright: </strong>Shows up in the footer to show that the app is super outdated</li>
                                    <li style="margin-bottom: 6px;"><strong>recordName: </strong>Like an Appian record name</li>
                                    <li style="margin-bottom: 6px;"><strong>shortName: </strong>Used in places like buttons</li>
                                    <li style="margin-bottom: 6px;"><strong>shortNamePlural: </strong>What do we call multiple records?</li>
                                    <li style="margin-bottom: 6px;"><strong>lineItemRecordName: </strong>What do we call a line item?</li>
                                    <li style="margin-bottom: 6px;"><strong>lineItemRecordNamePlural: </strong>What do we call multiple line items?</li>
                                    <li style="margin-bottom: 6px;"><strong>firstIdNumber: </strong>Integer value for the first record.. Will increment up for each new record</li>
                                </ul>
                            </li>
                            <li><strong>fields</strong>
                                <ul>
                                    <li style="margin-bottom: 6px;"><strong>hidden: </strong>Fields that won't show up in the form, but are accessible through RPA</li>
                                    <li style="margin-bottom: 6px;"><strong>visible: </strong>Fields that users will fill in, broken up by section<ul>
                                            <li style="margin-bottom: 6px;margin-top: 6px;"><strong>Line Items: </strong>You can create ONE section called "Line Items" and it will name the section whatever you set in <strong>lineItemRecordName</strong>.
                                                <ul>
                                                <li>Don't name it anything other than "Line Items"</li>
                                                <li>If you don't need line items, just delete this section.</li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li style="margin-bottom: 6px;"><strong>summaryFields: </strong>This is like the Appian record list.. make sure it's a field from above, but not a field from the line items.</li>
                            <li style="margin-bottom: 6px;"><strong>friendlyFieldNameOverrides: </strong>Override a field name you don't want to show using title case</li>
                        </ul>
                    </small></div>
            </td>
            <td style="width: 50%; vertical-align:top;">
                <?php
                if ($count == 0) {
                    include("./dataform.php");
                } else {
                ?>
                    <h2>
                        4. data.json
                    </h2><br><br>
                    <small>(<a href="https://restfulapi.net/json-syntax/" target="_blank">JSON Syntax Refresher</a>)</small><br>
                    <textarea name="data" id="data" cols="75" rows="40"><?= json_encode($data, JSON_UNESCAPED_SLASHES); ?></textarea>
                <?php
                }
                ?>
            </td>
    </table>
</form>