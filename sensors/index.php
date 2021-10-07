<?php
    $sensors = ["Office1","Driveway1","Courtyard1","Bouy1","Bouy2","Bouy3","Tower1","Tower2","Tower3"];
?>
<h1>Sensors</h1>
<table style="border: 1px solid #000000;">
    <tr style="border: 1px solid #000000;">
        <th style="border: 1px solid #000000;">Sensor Name</th>
        <th style="border: 1px solid #000000;">Value</th>
    </tr>
    <?php
        foreach($sensors as $key => $sensor){
            echo "<tr style=\"border: 1px solid #000000;\"><td style=\"border: 1px solid #000000;\" id=\"name-$key\">$sensor</td><td style=\"border: 1px solid #000000;\" id=\"value-$key\">".rand(55,82)."</td></tr>";
        }
    ?>
</table>