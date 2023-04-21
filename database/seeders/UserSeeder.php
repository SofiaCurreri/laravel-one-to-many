<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = "Mario";
        $user->email = "itsme@mario.com";
        $user->password = "password"; //qui password settata in chiaro ma setPasswordAttribute() in User.php me la hasha
        $user->save();
    }
}