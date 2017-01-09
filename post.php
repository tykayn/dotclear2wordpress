<?php

// take post infos


require( 'src/config.php' );
require( 'src/connect.php' );



require( 'src/tpl/head.php' );


// take posts
// check if wordpress posts exist
// if not, create them
// link to wp categories
// link to wp user
// link to wp tags
require( 'src/find_blogs.php' );
require( 'src/find_posts.php' );



// take users
// check if wordpress users exist
// if not, create them
require( 'src/find_users.php' );
// take categories
// check if wordpress categories exist
// if not, create them
require( 'src/find_cats.php' );
// take tags
// check if wordpress tags exist
// if not, create them

require( 'src/find_tags.php' );
echo ' < br />  récupération des tags';

// post et tags reliés
//foreach ($tags as $k=>$v) {
//	echo "<br>- ".$k.' : ';
//	foreach ($v as $item) {
//		echo '/ '.$item;
//	}
//}
echo " </div>";


// rapport des objets créés
// rapport des objets non créés
//require( 'logic/reports.php' );
?>
<h2>Rapports :</h2>
<?php

//print_r($reports);
echo $GLOBALS['reports'] ; ?>

<?php
require( 'src/tpl/foot.php' );
?>
