<?php
/**
 * Created by PhpStorm.
 * User: tykayn
 * Date: 18/08/16
 * Time: 12:30
 */

/**
 * info log
 * @param $text
 */
function ilog($text)
{
    $GLOBALS[ 'reports' ] = $GLOBALS[ 'reports' ]." <br/><div class='alert alert-info'>  $text</div>";
}

/**
 * make a slug title for a blog
 * @param $text
 * @return mixed|string
 */
function slugify($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty( $text )) {
        return 'n-a';
    }

    return $text;

}

/**
 * custom mysql real escape string
 * @param $value
 * @return mixed
 */
function mres($value)
{
    $search = ["\\", "\x00", "\n", "\r", "'", '"', "\x1a", "&#039;"];
    $replace = ["\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z", "\'"];
//    $value = str_replace($search, $replace, $value);

    return str_replace($search, $replace, $value);
}