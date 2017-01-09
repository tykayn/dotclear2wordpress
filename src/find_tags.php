<?php
/**
 * Created by PhpStorm.
 * User: tykayn
 * Date: 10/08/16
 * Time: 11:14
 */

echo '<h2>récupération des tags </h2>';


// find posts of the choosen blog_id with custom prefix
$sql = 'SELECT * FROM `dc_meta` WHERE meta_type = "tag" ORDER BY meta_id DESC';
try {
    $result = $dc_bdd->query($sql);
} catch (PDOException $e) {
    echo 'Echec de la connexion : '.$e->getMessage();
    exit;
}

$result->setFetchMode(PDO::FETCH_OBJ);
$tags = [];
$tagsTimes = []; // number of times a tag is found

echo "<br/>résultats des tags:";

/**
 * tags DC
 */
while ($donnees = $result->fetch()) {
//	var_dump($donnees);
    if (!isset( $tagsTimes[ $donnees->meta_id ] )) {
        $tagsTimes[ $donnees->meta_id ] = 0;
    }
    if (!isset( $tags[ $donnees->post_id ] )) {
        $tags[ $donnees->post_id ] = [];
    }
    $tags[ $donnees->post_id ][] = $donnees->meta_id;
    $tagsTimes[ $donnees->meta_id ]++;
}
$result->closeCursor();


/**
 * tags WP
 */

$sql_get_wp = 'SELECT ID,post_name FROM `'.$_SESSION[ 'configs' ][ 'wp_prefix' ].'posts` ';

//$result_wp = $_SESSION[ 'bdd' ][ 'wp' ]->query($sql_get_wp);
//$result_wp->setFetchMode(PDO::FETCH_OBJ);
//$wp_posts = [];
//$common_posts = [];
//$wp_posts_ids = [];
//$wp_posts_names = [];
//$wp_posts_by_names = [];
//while ($donnees = $result_wp->fetch()) {
//    $wp_posts[ $donnees->ID ] = ['slug' => $donnees->post_name, 'obj' => $donnees];
//    $wp_posts_ids[ $donnees->ID ] = $donnees->post_name;
//    $wp_posts_by_names[$donnees->post_name] = $donnees->ID;
//    $wp_posts_names[] = $donnees->post_name;
//}


echo " <div class='well'>
 <h2>".count($tags)." tags</h2>
 les 10 plus fréquents:";
// montrer le nombre de fois qu'un tag est utilisé
arsort($tagsTimes);
foreach (array_slice($tagsTimes, 0, 10) as $tagsTime => $counting) {
    echo "<br> - ".$tagsTime.' x '.$counting;
}


