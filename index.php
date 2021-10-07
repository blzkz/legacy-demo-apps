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
        echo "<li><a href=\"$page\">$name</a></li>";
    }



    ?>
</ol>
<br><br><hr><br>
<form action="./gitpull.php" method="POST">
    <button type="button">Update from GitHub</button>
</form>
<a href="https://github.com/jscanzoni/legacy-demo-apps">GitHub Repo</a>