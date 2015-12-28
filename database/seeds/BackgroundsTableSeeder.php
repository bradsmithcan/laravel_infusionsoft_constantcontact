<?php namespace Database\seeds;

use Illuminate\Database\Seeder;
use App\Models\Background;

class BackgroundsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $backgrounds = ['home-bg1.jpg','home-bg2.jpg','home-bg3.jpg','home-bg4.jpg', 'home-bg5.jpg', 'home-bg6.jpg'];
        foreach($backgrounds as $background){
            $bg = Background::where('name', '=', $background)->first();
            if(!$bg){
                Background::create([
                    'name' => $background,
                ]);
            }
        }
    }
}
