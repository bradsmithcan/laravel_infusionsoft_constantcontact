<?php namespace Database\seeds;

use Illuminate\Database\Seeder;
use App\Models\Api;

class ApisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $apis = ['MailChimp','GetResponse','iContact','Infusionsoft', 'Madmimi', 'AWeber', 'Constant Contact'];
        foreach($apis as $ap){
            $api = Api::where('name', '=', $ap)->first();
            if(!$api){
                Api::create([
                    'name' => $ap,
                ]);
            }
        }
    }
}
