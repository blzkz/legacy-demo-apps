<h3>Local Directories</h3>
<ol>
    <?php

    $dir    = './';
    $files = scandir($dir);

    ksort($files);

    $additional = [
        "PHP Info" => "phpinfo.php",
    ];

    ksort($additional);


    foreach ($files as $file) {
        if (!str_contains($file, ".")) {
            echo "<li><a href=\"$file\">".ucwords($file)."</a></li>";
        }
    }
    ?>
</ol>
<h3>Other Links</h3>
<ol>
    <?php
    foreach ($additional as $name => $page) {
        echo "<li><a href=\"$page\">$name</li>";
    }


    ?>
</ol>