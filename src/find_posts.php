<?php
/**
 * Created by PhpStorm.
 * User: tykayn
 * Date: 10/08/16
 * Time: 11:14
 */

echo ' <br/>  récupération des posts du blog '.$_SESSION[ 'configs' ][ 'blog_name' ];

// find posts of the choosen blog_id with custom prefix
$sql = 'SELECT * FROM `'.$_SESSION[ 'configs' ][ 'dc_prefix' ].'post` WHERE blog_id="'.$_SESSION[ 'configs' ][ 'blog_name' ].'" ORDER BY post_id DESC LIMIT '.$limits_dc_posts;
// prendre les posts wp
// comparer par le slug post_name pour savoir qui a déjà été importé
$sql_get_wp = 'SELECT ID,post_name FROM `'.$_SESSION[ 'configs' ][ 'wp_prefix' ].'posts` ';

$result_wp = $_SESSION[ 'bdd' ][ 'wp' ]->query($sql_get_wp);
$result_wp->setFetchMode(PDO::FETCH_OBJ);
$wp_posts = [];
$common_posts = [];
$wp_posts_ids = [];
$wp_posts_names = [];
$wp_posts_by_names = [];
while ($donnees = $result_wp->fetch()) {
    $wp_posts[ $donnees->ID ] = ['slug' => $donnees->post_name, 'obj' => $donnees];
    $wp_posts_ids[ $donnees->ID ] = $donnees->post_name;
    $wp_posts_by_names[$donnees->post_name] = $donnees->ID;
    $wp_posts_names[] = $donnees->post_name;
}

echo " <code>".$sql_get_wp." </code>";
echo " <h2 class='alert-info alert alert-block'>".count($wp_posts_by_names)." posts existants chez WP</h2>";
foreach ($wp_posts_ids as $idwp => $p){
    echo "<br/> $idwp > $p";
}
$result = $_SESSION[ 'bdd' ][ 'dc' ]->query($sql);
$result->setFetchMode(PDO::FETCH_OBJ);
$posts = [];
$posts_to_create = [];
$dc_posts_names=[];
$dc_post_corres=[];
echo "<br/>résultats des posts:";
// find corresponding posts between dotclear and wp to link other objects like tags.
while ($donnees = $result->fetch()) {
    $posts[ $donnees->post_id ] = ['post_title' => $donnees->post_title, 'obj' => $donnees];
    // test if post slug already present in wp slugs,
    // so we dont have to import it again
    $slug = slugify($donnees->post_title);
    $dc_posts_names[] = $slug;
    if(!in_array($slug, $wp_posts_names)){
        $posts_to_create[ $donnees->post_id ] = ['post_title' => $donnees->post_title, 'obj' => $donnees];
    }else{
        // map the correspondance between posts in dc and wp
        // exemple:
        // $dc_post_corres[DC__post_id] = wp__ID
        $dc_post_corres[$donnees->post_id ] = intval($wp_posts_by_names[$donnees->post_title]);
    }

}
// manage corresponding tags
echo "<br/> <h2>posts correspondants: " .count($dc_post_corres)."</h2>";

$result->closeCursor();

echo " <div class='well'>
 <h2>".count($posts_to_create)." posts à créer sur ".count($posts)."</h2>

 les 10 plus récents:";

// by default, save the post author to be the 1st user of wordpress
$sql_create_posts = 'insert into '.$_SESSION[ 'configs' ][ 'wp_prefix' ]."posts (`post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`)
VALUES ";

foreach ( $posts_to_create  as $post) {
    $p = $post['obj'];
    if (1 == $p->post_status) {
        $status = 'publish';
    } else {
        $status = 'draft';
    }

// if there is no xhtml dotclear content, take the content of the wiki syntax
    if (!count($p->post_content_xhtml)) {
        $content = $p->post_content;
        ilog('no xhtml for post '.$p->post_title);
    } else {
        $content = $p->post_content_xhtml;
    }
    $content = mres($content);
// same thing for the excerpt
    if (!$p->post_excerpt_xhtml) {
        $excerpt = $p->post_excerpt;
    } else {
        $excerpt = $p->post_excerpt_xhtml;
    }
    $excerpt = mres($excerpt);
// open to comments
    if ('1' !== $p->post_open_comment) {
        $open_comment = 'closed';
    } else {
        $open_comment = 'open';
    }

    echo "<br>- ".$post[ 'post_title' ]." | ".strlen($content)." caractères.";
    $p = $post[ 'obj' ];
    $sql_create_posts .= "('1',
	 '".$p->post_creadt."', '".gmdate('Y-m-d H:i:s', strtotime($p->post_creadt))."', 
	  '".$content."', '".mres($p->post_title)."', '".mres($p->post_excerpt)."',
	 '".$status."', '".$open_comment."', '".$open_comment."', '', '".slugify($p->post_title)."', '', '',
	  '".$p->post_upddt."','".gmdate('Y-m-d H:i:s', strtotime($p->post_upddt))."',
	   '', '0', '', '0','".$p->post_type."', '', '0'),";
}
// ending values insert
$sql_create_posts = substr($sql_create_posts, 0, -1).';';
$sql_create_posts = str_replace(['&lt;', '&gt;'], ['<', '>'], $sql_create_posts);
if($GLOBALS['debug']){
    echo " </div>
 
 <div>
 sql to insert new posts: <br>
 <pre><textarea style='width: 100%; height: 50px;'>
 
 $sql_create_posts
</textarea>
</pre>
 
</div>
Exécution de la requête de création de posts: ";
}


if ($enable_creation) {
    try {

      $retour =   $_SESSION[ 'bdd' ][ 'wp' ]->exec($sql_create_posts);

    } catch (Exception $e) {
        trigger_error($e->getMessage(), E_USER_ERROR);
    }
    var_dump($retour);
    echo " <div class=\"alert alert-success\"> OK ".$retour." sur ".count($posts)." posts créés sur </div>";

} else {
    echo " <div class=\"alert alert-warning\"> sauvegarde désactivée pour ".count($posts)." posts </div>";
}
