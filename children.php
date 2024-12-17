<?php
require "Database.php";
$config = require("config.php");

echo '<link rel="stylesheet" type="text/css" href="style_children.css">'; 

$db = new Database($config["database"]); 
$children = $db->query("SELECT * FROM children")->fetchAll(); 
$letters = $db->query("SELECT * FROM letters")->fetchAll();
$gifts = $db->query("SELECT * FROM gifts")->fetchAll();

$giftNames = [];
foreach ($gifts as $gift) {
    $giftNames[] = $gift['name'];  // visi gifts nosaukumi
}


echo "<h2>🎄 Ziemassvētku saraksts 🎅</h2>";
echo "<div class='cards-container'>"; //Konteineris priekrtitem
foreach ($children as $child) {
    echo "<div class='card'>";
    echo "<h3>🎁 " . $child["firstname"] . " " . $child["middlename"] . " " . $child["surname"] . " - " . $child["age"] . " 🎁</h3>";
    
   //bērna vēstule
    $childLetters = array_filter($letters, function ($letter) use ($child) {
        return $letter['sender_id'] == $child['id']; 
    });

    foreach ($childLetters as $letter) {
        echo "<div class='letter-card'>";
        echo "<h4>🎄 Vēstule:</h4>";
        
        // Dabu tekstu
        $letterText = $letter['letter_text'];
        
        // Aizvieto gift names ar bold
        foreach ($giftNames as $giftName) {
            $letterText = preg_replace("/\b" . preg_quote($giftName, '/') . "\b/i", "<strong>" . $giftName . "</strong>", $letterText);
        }
        
        // Updateojam tekstu
        echo "<p>" . nl2br($letterText) . "</p>";  // Izvadam tekstu
        echo "</div>";
     
        /* 
        echo "<h4>Vēlmes:</h4>";
        echo "<ul>";
        
        // Pārbauda vai bold vārdi ir tekstā
        foreach ($giftNames as $giftName) {
            // Pieliek vārdu listam ja atrod
            if (stripos($letterText, $giftName) !== false) {
                echo "<li><strong>$giftName</strong></li>";
            }
        }
        */
        echo "</ul>";
    }

    echo "</div>"; // Kartiņas beigas
}

echo "</div>"; // Beigas kartīšu konteinerim

//Priekš sniegpārslām
for ($i = 0; $i < 50; $i++) {
    $xPos = rand(0, 100); // random horizontāls izmēra
    $delay = rand(0, 5); 
    $duration = rand(7, 12); // Random laiks starp 7 - 12 s
    echo "<div class='snowflake' style='left: $xPos%; animation-delay: {$delay}s; animation-duration: {$duration}s;'>❄</div>";
}
?>
