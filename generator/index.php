<?php
include("functions.php");
$count = 0;
$data = null;
$app_folder = null;

if (isset($_POST['app_folder']))
    $app_folder = $_POST['app_folder'];


if (!isset($_POST['config']))
    $config = file_get_contents('./template/data/config.json');
else
    $config = $_POST['config'];

if (isset($_POST['update']))
    unset($_POST['data']);



if (isset($_POST['firstData'])) {
    $settings = json_decode($config, true);

    foreach ($settings["fields"]["hidden"] as $field) {
        $data[0][$field] = $_POST[$field];
    }
    foreach ($settings["fields"]["visible"] as $section => $items) {
        foreach ($items as $field) {
            $data[0][$field] = $_POST[$field];
        }
    }
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
                    <input type="text" name="app_folder" id="app_folder" value="<?= $app_folder; ?>" size="45"><br>
                    <small>Please use a <strong>unique</strong> name and don't use spaces.</small><br><br>
                    <div style="text-align:right"><button name="publish" <?= ($count < 1 ? "disabled" : ""); ?>>5. Publish App</button></div>
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
                <button name="update">Update Form and Clear Data</button><br><br>
                <textarea name="config" id="config" cols="75" rows="40"><?= $config; ?></textarea>
            </td>
            <td style="width: 50%;">
                <?php
                if ($count == 0) {
                    include("./dataform.php");
                } else {
                ?>
                    <h2>
                        4. data.json
                    </h2><br><br>
                    <textarea name="data" id="data" cols="75" rows="40"><?= json_encode($data, JSON_UNESCAPED_SLASHES); ?></textarea>
                <?php
                }
                ?>
            </td>
    </table>
</form>