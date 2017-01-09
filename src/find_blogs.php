<?php
// trouver les blogs si il y en a plusieurs
$request = 'SELECT * FROM `'.$_SESSION[ 'configs' ][ 'dc_prefix' ].'blog` GROUP BY blog_id';
$reponse = $_SESSION[ 'bdd' ][ 'dc' ]->query($request);

echo "<h2>Plusieurs blogs différents pour cette installation de wordpress</h2>   
 
 <div class='well'>";
// On affiche chaque entrée une à une
while ($donnees = $reponse->fetch())
{
echo "<br/>     <strong>". $donnees['blog_id'] . "</strong> , " . $donnees['blog_name'] . " | " . $donnees['blog_desc'];
}
echo "</div>";
