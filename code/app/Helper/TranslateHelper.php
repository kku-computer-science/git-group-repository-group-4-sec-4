<?php
namespace App\Helpers;

use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslateHelper {
    public static function translate($text, $targetLang) {
        $apiKey = env('GOOGLE_TRANSLATE_API_KEY');
        
        if (!$apiKey) {
            return $text; // ถ้าไม่มี API Key ให้คืนค่าเดิม
        }

        try {
            $translator = new GoogleTranslate();
            $translator->setTarget($targetLang);
            return $translator->translate($text);
        } catch (\Exception $e) {
            return $text; // กรณีแปลไม่ได้ ให้คืนค่าต้นฉบับ
        }
    }
}