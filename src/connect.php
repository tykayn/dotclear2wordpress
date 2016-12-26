<?php
/**
 * Created by PhpStorm.
 * User: tykayn
 * Date: 10/08/16
 * Time: 10:40
 *
 * fetch DC infos in database
 */


if (!isset( $_SESSION[ 'configs' ] )) {
    if(!isset($_POST['user'])){
        header('Location: index.php');
    }
    // get post params from the submitted form
    $user = $_POST[ 'user' ];
    $password = $_POST[ 'dc_pass' ];
    $dotclear_db_name = $_POST[ 'dc_bdd' ];
    $dotclear_blog_name = $_POST[ 'blog_name' ];
    $dc_prefix = $_POST[ 'dc_prefix' ];
    $wp_prefix = $_POST[ 'wp_prefix' ];
    $wp_db_name = $_POST[ 'wp_bdd' ];
    // stocker en session les configs, n'utiliser ensuite que ces infos de session
    $_SESSION[ 'configs' ] = [
        'user'      => $user,
        'password'  => $password,
        'dc_prefix' => $dc_prefix,
        'wp_prefix' => $wp_prefix,
        'wp_bdd'    => $wp_db_name,
        'blog_name' => $dotclear_blog_name,
        'dc_bdd'    => $dotclear_db_name,
    ];
    // table de correspondance entre WP et DC
    $_SESSION[ 'correspondances' ] =
        [
            'tags'  => [],
            'users' => [],
            'posts' => [],
        ];

} else {
    ilog('config taken from session');
}

$options = [
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
];


/**
 * Dotclear connec
 */
try {
    /* Connexion à une base ODBC avec l'invocation de pilote */
    $dsn = 'mysql:dbname='.$_SESSION[ 'configs' ][ 'dc_bdd' ].';host=127.0.0.1';
    $dc_bdd = new PDO($dsn, $_SESSION[ 'configs' ][ 'user' ], $_SESSION[ 'configs' ][ 'password' ], $options);
    $_SESSION[ 'bdd' ][ 'dc' ] = $dc_bdd;
    ilog(" <br> connexion dotclear réussie");

} catch (PDOException $e) {
    echo 'Connexion Dotclear sur la base '.$_SESSION[ 'configs' ][ 'dc_bdd' ].' échouée : '.$e->getMessage();
}
/**
 * Wordpress connec
 */
try {
    $dsn = 'mysql:dbname='.$_SESSION[ 'configs' ][ 'wp_bdd' ].';host=127.0.0.1';
    $wp_bdd = new PDO($dsn, $_SESSION[ 'configs' ][ 'user' ], $_SESSION[ 'configs' ][ 'password' ], $options);
    ilog(" <br> connexion wordpress réussie");
    $_SESSION[ 'bdd' ][ 'wp' ] = $wp_bdd;
} catch (PDOException $e) {
    echo 'Connexion Dotclear sur la base '.$_SESSION[ 'configs' ][ 'wp_bdd' ].' échouée : '.$e->getMessage();
}
