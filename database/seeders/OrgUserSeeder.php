<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Hash;

class OrgUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FacadesDB::table('users')->delete();
        User::create([
            'name'=>'admin',
            'email'=>'admin@admin',
            'password'=>Hash::make('123123123'),
            'rule'=>'admin'
        ]);

          User::factory()->count(22)->create();
    }
}
