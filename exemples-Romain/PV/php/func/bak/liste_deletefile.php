<?php 
// appelé par index.php (AJAX)
   unlink("../".$_POST['path'].$_POST['file']);
   echo "fichier ".$_POST['file']." supprimé";
?>