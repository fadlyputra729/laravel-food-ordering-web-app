<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('food')->insert([
            [
                'name' => 'Bolu Tape',
                'price' => 35000,
                'description' => 'Bolu lembut dengan rasa tape yang khas. Ukuran 20X10 = Rp. 35.000 | 20X20 = Rp. 65.000 Loyang ',
                'type' => 'bolu',
                'picture' => 'storage/menu/bolu-tape.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Brownies Panggang',
                'price' => 65000,
                'description' => 'Brownies dengan tekstur renyah di luar dan lembut di dalam. Ukuran 20x20',
                'type' => 'brownies',
                'picture' => 'storage/menu/brownies-panggang.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Brownies Ulang tahun',
                'price' => 70000,
                'description' => 'Brownies spesial untuk hari ulang tahun. Bisa request ucapan dan free lilin',
                'type' => 'brownies',
                'picture' => 'storage/menu/brownis-ultah.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fuggie Brownies',
                'price' => 35000,
                'description' => 'Brownies fudgy dengan rasa cokelat yang pekat. Ukuran 22x10cm.',
                'type' => 'brownies',
                'picture' => 'storage/menu/fuggie-brownies.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Marmer Cake',
                'price' => 70000,
                'description' => 'Cake dengan motif marmer yang cantik dan lembut. Diameter 24cm.',
                'type' => 'cake',
                'picture' => 'storage/menu/marmer-cake.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
