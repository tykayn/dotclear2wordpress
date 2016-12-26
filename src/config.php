<?php
/**
 * Created by PhpStorm.
 * User: tykayn
 * Date: 11/08/16
 * Time: 21:12
 */
$enable_creation = 0;
//$enable_creation = 1;
$limits_dc_posts = "200"; // limit of dotclear posts to fetch for creation
$reports = "";
$GLOBALS['reports'] = '';
$GLOBALS['debug'] = 0;

require('functions.php');
if(!$enable_creation){
    echo " <div class=\"alert-warning\">Sauvegarde désactivée</div>  ";
}
?>

