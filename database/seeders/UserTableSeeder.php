<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'CareClick',
            'email'=>'contact@careclick.healthcare',
            'password'=>bcrypt('CareClick12')
        ]);
    }
}
