<?php
require "Database.php";
$config = require("config.php");

echo '<link rel="stylesheet" type="text/css" href="style_gifts.css">';  // Pievieno CSS failu

// Savieno ar datu bāzi
$db = new Database($config["database"]); 

// Iegūst visus dāvanas un vēstules
$gifts = $db->query("SELECT * FROM gifts")->fetchAll(); 
$letters = $db->query("SELECT * FROM letters")->fetchAll();

// Izveido masīvu, lai uzglabātu, cik bērni katru dāvanu ir izvēlējušies
$giftRequests = [];
foreach ($letters as $letter) {
    // Meklē katru dāvanu, kas minēta vēstulē
    foreach ($gifts as $gift) {
        if (stripos($letter['letter_text'], $gift['name']) !== false) {
            if (!isset($giftRequests[$gift['name']])) {
                $giftRequests[$gift['name']] = 0;
            }
            $giftRequests[$gift['name']]++;  // Palielina pieprasīto skaitu
        }
    }
}

echo "<h2>🎄 Pieejamās dāvanas 🎅</h2>";  // Virsraksts
echo "<ol>"; 
foreach ($gifts as $gift) {
    // Skaita, cik bērni pieprasījuši katru dāvanu
    $requestedCount = isset($giftRequests[$gift['name']]) ? $giftRequests[$gift['name']] : 0;
    $remainingCount = $gift['count_available'] - $requestedCount;
    $status = $remainingCount >= 0 ? "Pietiek!" : "Nav pietekami dāvanu!";

    // Parāda dāvanas nosaukumu, pieprasīto un atlikušo daudzumu
    echo "<li>";
    echo "🎁 " . $gift["name"] . " - Pieprasīts: " . $requestedCount . " - Atlikušais: " . $remainingCount . " ";
    echo "<span class='status " . ($remainingCount >= 0 ? "enough" : "not-enough") . "'>$status</span>";
    echo " 🎁";
    echo "</li>";
}
echo "</ol>"; // Beidzot sarakstu

// sniegpārslas 
for ($i = 0; $i < 30; $i++) {
    $xPos = rand(0, 100);
    $delay = rand(0, 5);
    $duration = rand(5, 10);
    echo "<div class='snowflake' style='left: $xPos%; animation-delay: {$delay}s; animation-duration: {$duration}s;'>❄</div>";
}
?>
