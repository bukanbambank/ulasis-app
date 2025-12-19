<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\QrCode;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

echo "--- Seeding Realistic Data (Indonesian) ---\n";

// Target: strong_agent
$user = User::where('email', 'strong_agent@ulasis.site')->first();
if (!$user) {
    die("User not found.");
}
$tenantId = $user->tenant_id;
echo "Tenant: $tenantId\n";

// Target: Any QR Code
$qr = QrCode::where('tenant_id', $tenantId)->first();
if (!$qr) {
    die("No QR Code found to attach feedback to.");
}
echo "QR Context: {$qr->name}\n";

// Data Corpus
$reviews = [
    5 => [
        "Makanannya enak banget, bumbunya pas!",
        "Pelayanan sangat ramah dan cepat. Puas!",
        "Tempatnya nyaman buat nongkrong lama.",
        "Kopinya mantap, baristanya asik.",
        "Best fried rice in town! Pasti balik lagi.",
        "Bersih, rapi, dan harganya terjangkau.",
        "Suka banget sama suasana restorannya.",
        "Recommended banget buat makan bareng keluarga."
    ],
    4 => [
        "Makanan enak, tapi nunggunya agak lama.",
        "Overall oke, cuma AC-nya kurang dingin.",
        "Tempat bagus, harga standar.",
        "Rasanya lumayan, porsi cukup besar.",
        "Oke sih, tapi musiknya terlalu kencang.",
        "Pelayanannya baik, menu variatif."
    ],
    3 => [
        "Biasa aja rasanya, nothing special.",
        "Harganya agak mahal untuk porsi segini.",
        "Parkirannya susah banget.",
        "Mejanya agak lengket, tolong diperhatikan.",
        "Lumayan buat ganjal perut."
    ],
    2 => [
        "Pelayanan lama banget, padahal lagi sepi.",
        "Makanannya datang sudah dingin.",
        "Pesan es teh manis malah dikasih tawar.",
        "Kurang worth it sama harganya."
    ],
    1 => [
        "Sangat mengecewakan. Makanan asin banget.",
        "Pelayan jutek, tidak ada senyum.",
        "Ada rambut di makanannya. Bad experience.",
        "Toilet kotor dan bau."
    ]
];

// Generate last 30 days
$startDate = Carbon::now()->subDays(30);
$total = 0;

for ($i = 0; $i <= 30; $i++) {
    $currentDate = $startDate->copy()->addDays($i);

    // Vary daily volume: 0 to 8 customers
    // Weekends (Sat/Sun) might be busier
    $isWeekend = $currentDate->isWeekend();
    $dailyCount = $isWeekend ? rand(3, 8) : rand(0, 5);

    for ($j = 0; $j < $dailyCount; $j++) {
        // Determine Sentiment (Weighted)
        // 60% Happy, 20% Neutral, 20% Unhappy
        $rand = rand(1, 100);
        if ($rand <= 60) {
            $rating = rand(4, 5);
        } elseif ($rand <= 80) {
            $rating = 3;
        } else {
            $rating = rand(1, 2);
        }

        $comment = $reviews[$rating][array_rand($reviews[$rating])];

        // Randomize time within Lunch (11-14) or Dinner (18-21)
        $hour = (rand(0, 1) === 0) ? rand(11, 14) : rand(18, 21);
        $minute = rand(0, 59);
        $timestamp = $currentDate->copy()->setTime($hour, $minute, 0);

        // Simulate ratings for 3 questions based on the overall sentiment
        // If sentiment is 5, give mostly 5s.
        $q_ratings = [];
        for ($k = 0; $k < 3; $k++) {
            // Add some variance: e.g. if rating is 4, maybe give 3, 4, 5
            $variance = rand(-1, 1);
            $score = max(1, min(5, $rating + $variance));
            $q_ratings[] = $score;
        }

        try {
            DB::table('feedback_responses')->insert([
                'tenant_id' => $tenantId,
                'qr_code_id' => $qr->id,
                'ratings' => json_encode($q_ratings),
                'feedback_text' => $comment,
                'customer_info' => json_encode([]),
                'status' => 'unread',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
            $total++;
        } catch (\Exception $e) {
            echo "INSERT ERROR: " . $e->getMessage() . "\n";
            exit(1);
        }
    }
}

echo "Successfully seeded $total feedback entries over 30 days.\n";
