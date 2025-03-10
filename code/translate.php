<?php
require 'vendor/autoload.php'; // โหลด Composer autoload

use Stichoza\GoogleTranslate\GoogleTranslate;

$tr = new GoogleTranslate();
$tr->setSource('en'); // แปลจากอังกฤษ
$tr->setTarget('th'); // แปลเป็นไทย

$text = "Hello, how are you?"; // ข้อความที่ต้องการแปล
$translatedText = $tr->translate($text);

echo "ข้อความที่แปล: " . $translatedText;
?>