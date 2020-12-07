<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Column;
use App\Models\Card;
use DB;

class ColumnsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Column::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $faker = \Faker\Factory::create();
        $cards = Card::all()->pluck('id')->toArray();

        for ($i=0;$i<5;$i++) {
            $card_id = $faker->randomElement($cards);
            Column::create([
                'title' => $faker->sentence(),
                'head_card' => $card_id
            ]);
        }


    }
}
