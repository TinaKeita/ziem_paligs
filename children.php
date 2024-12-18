<?php
require "Database.php";
$config = require("config.php");

// Ielādējam stilu
echo '<link rel="stylesheet" type="text/css" href="style_children.css">'; 

// Pieslēdzamies datubāzei
$db = new Database($config["database"]); 

// Saņemam nepieciešamos datus no datubāzes
$children = $db->query("SELECT * FROM children")->fetchAll(); 
$letters = $db->query("SELECT * FROM letters")->fetchAll();
$gifts = $db->query("SELECT * FROM gifts")->fetchAll();

// Izveidojam masīvu ar visām dāvanu nosaukumiem
$giftNames = [];
foreach ($gifts as $gift) {
    $giftNames[] = $gift['name'];  // Pievienojam dāvanu nosaukumus
}

// Galvenais virsraksts
echo "<h2>🎄 Ziemassvētku saraksts 🎅</h2>";
echo "<div class='cards-container'>"; // Konteiners priekš bērnu kartītēm

//Cauri katram bērnam
foreach ($children as $child) {
    echo "<div class='card'>"; // Katras bērna kartītes sākums
    echo "<h3>🎁 " . $child["firstname"] . " " . $child["middlename"] . " " . $child["surname"] . " - " . $child["age"] . " 🎁</h3>";
    
    // Filtrējam bērna vēstules
    $childLetters = array_filter($letters, function ($letter) use ($child) {
        return $letter['sender_id'] == $child['id']; 
    });

    // Cauri bērna vēstulēm
    foreach ($childLetters as $letter) {
        echo "<div class='letter-card'>"; // Kartīte priekš vēstules
        echo "<h4>🎄 Vēstule:</h4>";
        
        // Vēstules teksts
        $letterText = $letter['letter_text'];
        
        // Aizvietojam dāvanu nosaukumus ar bold tekstu
        foreach ($giftNames as $giftName) {
            $letterText = preg_replace("/\b" . preg_quote($giftName, '/') . "\b/i", "<strong>" . $giftName . "</strong>", $letterText);
        }
        
        // Izvadām vēstules tekstu
        echo "<p>" . nl2br($letterText) . "</p>";

        // Izvadām vēlmes, kas tika minētas vēstulē
        echo "<h4>Vēlmes:</h4>";
        echo "<ul>"; // Saraksts priekš vēlēmēm
        foreach ($giftNames as $giftName) {
            // Pārbaudām, vai dāvanu nosaukums (bold formātā) atrodas vēstules tekstā
            if (stripos($letterText, "<strong>$giftName</strong>") !== false) {
                echo "<li><strong>$giftName</strong></li>"; // Pievienojam sarakstam
            }
        }
        echo "</ul>";

        echo "</div>"; // Beidzam vēstules kartīti
    }

    echo "</div>"; // Beidzam bērna kartīti
}

echo "</div>"; // Beidzam kartīšu konteineru

// Sniegpārslas
for ($i = 0; $i < 50; $i++) {
    $xPos = rand(0, 100); // Random horizontālā pozīcija
    $delay = rand(0, 5); // Random aizkave
    $duration = rand(7, 12); // Random ilgums (7-12 sekundes)
    echo "<div class='snowflake' style='left: $xPos%; animation-delay: {$delay}s; animation-duration: {$duration}s;'>❄</div>";
}
?>
