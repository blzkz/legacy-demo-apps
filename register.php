<?php
if (file_exists("/var/www/html/.registered")) {
    $email = file_get_contents('/var/www/html/.registered');
} else {
    $email = "";
}

try {
    if (!file_exists("/var/www/html/.uuid")) {
        $uuid = uniqid();
        $uuidFile = fopen("/var/www/html/.uuid", "w") or die("Unable to open file!");
        fwrite($uuidFile, $uuid);
        fclose($uuidFile);
    } else {
        $uuid = file_get_contents('/var/www/html/.uuid');
    }
} catch (Throwable $t) {
    echo "Can't Backup Right Now <br>";
}

if (isset($_POST["submit"])) {
    $email = $_POST['email'];
    $emailFile = fopen("/var/www/html/.registered", "w") or die("Unable to open file!");
    fwrite($emailFile, $email);
    fclose($emailFile);

    echo "updated!<br><br>";
    header("Location: /index.php");

}

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<h1>Legacy Apps Generator Registration</h1>
<h3>Let's make sure your configuration files are registered properly to get started.</h3>
<hr><br><br>
<form action="./register.php" method="POST">
    <label for=email>Please enter your Appian email address:</label><br />
    <input type="text" id="email" name="email" value="<?= $email; ?>" size="100"><br />
    <h2 id="result"></h2>

    <button name="submit" id="submit" disabled>Register</button>
</form><br><br>

<script>
    function validateEmail(email) {
        const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@(appian.com\s*)$/;
        return re.test(email);
    }

    function validate() {
        const $result = $("#result");
        const $submit = $("#submit");
        const email = $("#email").val();
        $result.text("");

        if (validateEmail(email)) {
            $result.text(email + " looks good!");
            $result.css("color", "green");
            $submit.prop("disabled", false);
        } else {
            $result.text(email + " doesn't look like an Appian email address.");
            $result.css("color", "red");
            $submit.prop("disabled", true);
        }
        return false;
    }

    $("#email").on("input", validate);
    if ($("#email").val().length > 0) {
        $("#email").ready(validate);
    }
</script>