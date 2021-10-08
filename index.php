<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<h3>Main Legacy Apps</h3>
<ol>
    <?php

    $dir    = './';
    $files = scandir($dir);

    ksort($files);

    $additional = [
        "PHP Info" => "phpinfo.php",
        "Legacy Apps Documentation (Google Doc)" => "https://docs.google.com/document/d/1VlcBsGNCLqQHomLhtFRr7gYgnluuUbmlHVL39XhSfSM/edit?usp=sharing",

    ];

    ksort($additional);


    foreach ($files as $file) {
        if (!str_contains($file, ".") && !str_contains($file, "app_") && $file !== "generator") {
            echo "<li><a href=\"$file\">" . ucwords($file) . "</a></li>";
        }
    }
    ?>
</ol>
<br>
<h3>Generated Legacy Apps</h3>
<ol>
    <?php

    foreach ($files as $file) {
        if (!str_contains($file, ".") && str_contains($file, "app_")) {
            echo "<li><a href=\"$file\">" . ucwords(str_replace("app_", "", $file)) . "</a></li>";
        }
    }
    ?>
</ol>
<form action="/generator/"><button>Create New App</button></form>
<br><br>
<h3>Other Links</h3>
<ol>
    <?php
    foreach ($additional as $name => $page) {
        echo "<li><a href=\"$page\">$name</a></li>";
    }



    ?>
</ol>
<br><br>
<hr><br>
This application will stay up to date by syncing with the <a href="https://github.com/jscanzoni/legacy-demo-apps">Legacy Demo Apps GitHub Repo</a><br><br>
<small><strong>Version:</strong> <?= date(DATE_RFC822, exec("stat -c %Y .git/FETCH_HEAD")) ?></small>