<?php
function recurse_copy($src,$dst) {
    $dir = opendir($src);
    $oldmask = umask(0);
    @mkdir($dst, 0777);
    umask($oldmask);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
                chmod($dst . '/' . $file, 0777);
            }
            else {
                $oldmask = umask(0);
                copy($src . '/' . $file,$dst . '/' . $file);
                umask($oldmask);

                chmod($dst . '/' . $file, 0777);
            }
        }
    }
    closedir($dir);

}
?>