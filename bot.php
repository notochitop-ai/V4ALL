<?php
// تنظیمات ربات
define('BOT_TOKEN', '8412613086:AAHPN2U1SJ0EqhN_6OCEUKD_Dz6X_Z8RN2I');
define('ADMIN_ID', '435719319');
define('DB_HOST', 'localhost');
define('DB_USER', 'achostnet_v2pro');
define('DB_PASS', 'qq6Gy2J2hzm8cmBpxYs8');
define('DB_NAME', 'achostnet_v2pro');

// دریافت آپدیت
$input = file_get_contents('php://input');
$update = json_decode($input, true);

// لاگ
file_put_contents('log.txt', date('Y-m-d H:i:s') . " - " . $input . "\n", FILE_APPEND);

// توابع کمکی
function sendMessage($chatId, $text, $keyboard = null) {
    $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendMessage";
    $data = [
        'chat_id' => $chatId,
        'text' => $text,
        'parse_mode' => 'HTML'
    ];
    if ($keyboard) {
        $data['reply_markup'] = json_encode($keyboard);
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}

// پردازش پیام
if (isset($update['message'])) {
    $chatId = $update['message']['chat']['id'];
    $text = $update['message']['text'] ?? '';
    
    if ($text == '/start') {
        $keyboard = [
            'inline_keyboard' => [
                [['text' => '🛍 خرید سرویس', 'callback_data' => 'buy']],
                [['text' => '📱 سرویس‌های من', 'callback_data' => 'my']]
            ]
        ];
        
        sendMessage($chatId, "🚀 <b>ربات VPN</b>\n\nخوش آمدید!", $keyboard);
    }
}

echo "OK";
?>
