<?php 
// appelé par log.php (AJAX)
$path=$_POST['path'];

function scan_dir($dir) {
    $ignored = array('.', '..', '.svn', '.htaccess');

    $files = array();    
    foreach (scandir($dir) as $file) {
        if (in_array($file, $ignored)) continue;
        $files[$file] = filemtime($dir . '/' . $file);
    }

    arsort($files);
    $files = array_keys($files);

    return ($files) ? $files : false;
}


foreach (scan_dir("../".$path) as $file)  {
	echo '<p style="text-align:center"><i class="fas fa-file fa-sm devfile"></i> <a href="'.$path.$file.'">' . $file . '</a> <i class="fas fa-trash fa-sm" style="cursor: pointer;" onclick="delete_file(\''.$path.'\',\''.$file.'\')"></i></p>';
}


?>