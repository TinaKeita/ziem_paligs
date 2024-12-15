<?php
require "Database.php";
$config = require("config.php");

// Link to the external CSS file
echo '<link rel="stylesheet" type="text/css" href="style_gifts.css">';

$db = new Database($config["database"]); // Connect to the database
$children = $db->query("SELECT * FROM gifts")->fetchAll();

echo "<h2>🎄 Pieejamās dāvanas 🎅</h2>";  // Heading should be visible now
echo "<ol>";
    foreach ($children as $child) {
       echo "<li>🎁 " . $child["name"] . " - " . $child["count_available"] . " 🎁</li>";
    }
echo "</ol>";

// Add falling snowflakes dynamically, with random positions and animations
for ($i = 0; $i < 30; $i++) { // Increased number of snowflakes
    $xPos = rand(0, 100); // Random horizontal position (percentage of the screen)
    $delay = rand(0, 5); // Random delay to stagger the snowflakes
    $duration = rand(5, 10); // Random animation duration between 5-10 seconds
    echo "<div class='snowflake' style='left: $xPos%; animation-delay: {$delay}s; animation-duration: {$duration}s;'>❄</div>";
}
?>
