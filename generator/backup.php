
<?php
try {
    if (!file_exists("/var/www/html/.uuid")) {
        $uuid = uniqid();
        $uuidFile = fopen("/var/www/html/.uuid", "w") or die("Unable to open file!");
        fwrite($uuidFile, $uuid);
        fclose($uuidFile);
    } else {
        $uuid = file_get_contents('/var/www/html/.uuid');
    }

    echo $uuid . "<br><br>";


    $dir    = '/var/www/html/';
    $files = scandir($dir);

    ksort($files);

    foreach ($files as $file) {
        try {
            if (!str_contains($file, ".") && str_contains($file, "app_")) {
                $config = json_decode(file_get_contents("/var/www/html/$file/data/config.json"), true);
                $data = json_decode(file_get_contents("/var/www/html/$file/data/data.json"), true);

                $toSend = json_encode([
                    "folderName" => str_replace("app_", "", $file),
                    "appName" => $config["app_settings"]["appname"],
                    "recordName" => $config["app_settings"]["recordName"],
                    "date" => date("d/m/Y"),
                    "uuid" => $uuid,
                    "configJson" => $config,
                    "dataJson" => $data,
                ]);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://devcanvas.appiancloud.com/suite/webapi/archiveConfig");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERPWD, "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI3NzAxOTY5Yi0yNWMwLTQzYzgtYTUyMC05OTdhN2FmYzQ0OTkifQ.1ANz6UW-uRfRPgzximpyfJbM4wSDwzbqtoTwPBoV_KE:");
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $toSend);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                $output = curl_exec($ch);
                $info = curl_getinfo($ch);
                curl_close($ch);

                echo "Sent $file <br>";
                /*echo "$output <br>";
                echo var_dump($info);
                echo "<br><br>";*/
            }
        } catch (Throwable $t) {
            echo "Didn't send $file <br>";
            continue;
        }
    }
} catch (Throwable $t) {
    echo "Can't Backup Right Now <br>";
}

/*include "./includes/fields.php";

if (!$webhook_enabled)
    die("no webhook is enabled");

if (isset($_POST["action"])) {*/

/*
if (file_exists($file))
    $config = json_decode(file_get_contents($file), true);
else
    die("Can't find config.json");

$appname = $config["app_settings"]["appname"];

$cfile['file'] = curl_file_create($file, 'application/json', $appname.'-config.json'); 

$data = array('name' => $appname.'-config.json', 'file' => '@'.$file);

var_dump($cfile);

$ch = curl_init();
curl_setopt($ch, CURLOPT_USERAGENT, 'Opera/9.80 (Windows NT 6.2; Win64; x64) Presto/2.12.388 Version/12.15');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: Opera/9.80 (Windows NT 6.2; Win64; x64) Presto/2.12.388 Version/12.15', 'Referer: http://someaddress.tld', 'Content-Type: multipart/form-data'));
curl_setopt($ch, CURLOPT_URL, "https://empowertobuild.appiancloud.com/suite/webapi/upload-docs");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiI5NTU2ZWUyNy0yM2YyLTQ0NDEtOGMxOS1hYTJhNDA1YTYzMDQifQ.M_Pkwlbo0BRRdwo71YvHcFTiWs_FYfxPtK7MJm2osvg:");
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // if any redirection after upload
$output = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

echo $output;
var_dump($info);
*/

/*     foreach (json_decode($output) as $field => $value) {
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
}*/

?>