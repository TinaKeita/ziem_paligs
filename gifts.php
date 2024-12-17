<?php
require "Database.php";
$config = require("config.php");


echo '<link rel="stylesheet" type="text/css" href="style_gifts.css">';

$db = new Database($config["database"]); 
$children = $db->query("SELECT * FROM gifts")->fetchAll();
$gifts = $db->query("SELECT * FROM gifts")->fetchAll();

echo "<h2>🎄 Pieejamās dāvanas 🎅</h2>";  
echo "<ol>";
    foreach ($children as $child) {
       echo "<li>🎁 " . $child["name"] . " - " . $child["count_available"] . " 🎁</li>";
    }
echo "</ol>";


for ($i = 0; $i < 30; $i++) { 
    $xPos = rand(0, 100); 
    $delay = rand(0, 5); 
    $duration = rand(5, 10); 
    echo "<div class='snowflake' style='left: $xPos%; animation-delay: {$delay}s; animation-duration: {$duration}s;'>❄</div>";
}
?>
