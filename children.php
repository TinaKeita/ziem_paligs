<?php
require "Database.php";
$config = require("config.php");

echo '<link rel="stylesheet" type="text/css" href="style_children.css">'; //css fails

$db = new Database($config["database"]); 
$children = $db->query("SELECT * FROM children")->fetchAll(); 

echo "<h2>🎄 Bērnu vārdi 🎅</h2>";
echo "<ul>";
    foreach ($children as $child) {
       echo "<li>🎁 " . $child["firstname"] . " " . $child["middlename"] . " " . $child["surname"] . " - " . $child["age"] . " 🎁</li>";
    }
echo "</ul>";

//Priekš sniegpārslām
for ($i = 0; $i < 20; $i++) {
    $xPos = rand(0, 100); // random horizontāls izmēra
    $delay = rand(0, 5); 
    $duration = rand(7, 12); // Random laiks starp 7 - 12 s
    echo "<div class='snowflake' style='left: $xPos%; animation-delay: {$delay}s; animation-duration: {$duration}s;'>❄</div>";
}
?>
