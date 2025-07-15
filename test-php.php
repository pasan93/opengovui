<?php
echo "PHP is working! Current time: " . date('Y-m-d H:i:s');
echo "\nPHP Version: " . phpversion();
echo "\nWordPress database test:";

try {
    $pdo = new PDO('mysql:host=localhost;dbname=opengovui_wp', 'pasanthilakasiri', '');
    echo "\nDatabase connection: SUCCESS";
} catch (Exception $e) {
    echo "\nDatabase connection: FAILED - " . $e->getMessage();
}
?> 