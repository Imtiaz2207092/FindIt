<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\LostItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class LostItemSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->firstOrFail();

        $electronics = Category::firstOrCreate(['category_name' => 'Electronics']);
        $documents = Category::firstOrCreate(['category_name' => 'Documents']);
        $wallets = Category::firstOrCreate(['category_name' => 'Wallets']);

        $items = [
            [
                'category_id' => $electronics->id,
                'title' => 'iPhone 13 Pro Max',
                'description' => 'Graphite color iPhone 13 Pro Max with a clear case and small scratch on the back glass. Last used near the KUET central library.',
                'image' => null,
                'location' => 'KUET Central Library',
                'lost_date' => '2025-06-10',
                'status' => 'Lost',
            ],
            [
                'category_id' => $wallets->id,
                'title' => 'Leather Wallet with NID',
                'description' => 'Brown genuine leather wallet containing National ID card, two debit cards, and some cash. Lost near the main cafeteria entrance.',
                'image' => null,
                'location' => 'Main Cafeteria',
                'lost_date' => '2025-06-12',
                'status' => 'Matched',
            ],
            [
                'category_id' => $electronics->id,
                'title' => 'Black Dell Backpack',
                'description' => 'Black Dell laptop backpack with a red KUET keychain. Contains charger cables but no laptop. Lost on the way to ECE building.',
                'image' => null,
                'location' => 'ECE Building Road',
                'lost_date' => '2025-06-08',
                'status' => 'Lost',
            ],
            [
                'category_id' => $documents->id,
                'title' => 'KUET Student ID Card',
                'description' => 'KUET student ID card belonging to a 3rd year CSE student. Blue lanyard attached. Lost near the academic building corridor.',
                'image' => null,
                'location' => 'Academic Building',
                'lost_date' => '2025-06-14',
                'status' => 'Matched',
            ],
            [
                'category_id' => $electronics->id,
                'title' => 'Samsung Galaxy Buds2 Pro',
                'description' => 'White Samsung Galaxy Buds2 Pro in the original charging case. One earbud has a tiny sticker on it. Lost during morning jog at KUET stadium.',
                'image' => null,
                'location' => 'KUET Stadium',
                'lost_date' => '2025-06-05',
                'status' => 'Lost',
            ],
            [
                'category_id' => $documents->id,
                'title' => 'Semester Registration Form',
                'description' => 'Signed semester registration form and fee receipt in a transparent folder. Important for upcoming exam registration.',
                'image' => null,
                'location' => 'Registrar Office Area',
                'lost_date' => '2025-06-11',
                'status' => 'Lost',
            ],
            [
                'category_id' => $wallets->id,
                'title' => 'Blue Fabric Wallet',
                'description' => 'Small blue fabric wallet with KUET logo patch. Contains bus pass and library membership card only.',
                'image' => null,
                'location' => 'Bus Stand Gate 2',
                'lost_date' => '2025-06-09',
                'status' => 'Matched',
            ],
            [
                'category_id' => $electronics->id,
                'title' => 'Casio Scientific Calculator',
                'description' => 'Casio fx-991EX scientific calculator with name written on the back in marker. Essential for upcoming mid-term exams.',
                'image' => null,
                'location' => 'Room 304, Academic Building',
                'lost_date' => '2025-06-13',
                'status' => 'Lost',
            ],
        ];

        foreach ($items as $item) {
            LostItem::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'title' => $item['title'],
                ],
                $item + ['user_id' => $user->id]
            );
        }
    }
}
