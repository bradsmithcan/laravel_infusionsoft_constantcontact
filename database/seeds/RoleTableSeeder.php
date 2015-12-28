<?php namespace Database\seeds;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class RoleTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Normal User','Pro User', 'Admin', 'Free'];
        foreach($roles as $r){
            $role = Role::where('name', '=', $r)->first();
            if(!$role){
                Role::create([
                    'name' => $r,
                ]);
            }
        }
    }
}
