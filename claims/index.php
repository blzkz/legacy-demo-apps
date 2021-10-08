<?php
include "./includes/header.php";

?>
<table style="width: 950px; border: 1px solid #000000; margin-left:auto; margin-right:auto; padding: 0px;">
    <tr style="padding: 0px;">
        <td colspan="2" style="background-color: #999999; color: #FFFFFF; padding: 20px;">
            <h1>Claims App</h1>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td width="800px" style="border-right: 1px solid #000000; text-align: center; vertical-align:middle;">
            <form action="list.php" method="POST">
                <br /><br /><br /><br /><br />
                <div id="login">
                    <label for="uname"><b>Username</b></label>
                    <input type="text" placeholder="Enter Username" name="uname" required>
                    <br /><br />
                    <label for="psw"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="psw" required>
                    <br /><br />
                    <button type="submit">Login</button>
                    <br />
                    <br />
                    <label style="font-size: small; vertical-align: text-top;">
                        <input type="checkbox" checked="checked" name="remember"> Remember me
                    </label>
                </div>
                <br /><br /><br /><br /><br />
                <!--<div class="container" style="background-color:#f1f1f1">
                    <button type="button" class="cancelbtn">Cancel</button>
                    <span class="psw">Forgot <a href="#">password?</a></span>
                </div>-->
            </form>
        </td>
        <td style="text-align: center; vertical-align:top;"></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>
<?php

include "./includes/footer.php";

?>