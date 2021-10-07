<?php
include "./includes/header.php";

?>
<table style="width: 950px; border: 1px solid #000000; margin-left:auto; margin-right:auto; padding: 0px;">
    <tr style="padding: 0px;">
        <td colspan="2" style="background-color: #999999; color: #FFFFFF; padding: 20px;">
            <h1><?= $appname; ?></h1>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td width="800px" colspan="2" style="text-align: center; vertical-align:middle;">
            
        <?php include "./includes/data_summary.php" ?>
        </td>
        <!--<td style="text-align: center; vertical-align:top;"><?php include "./includes/data.php" ?></td>-->
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>
<?php

include "./includes/footer.php";

?>