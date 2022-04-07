<?php

namespace Database\Seeders;

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
        User::factory()->create([
            'email' => 'user1@szerveroldali.hu'
        ]);

        User::factory()->create([
            'email' => 'user2@szerveroldali.hu'
        ]);

        User::factory()->create([
            'email' => 'user3@szerveroldali.hu'
        ]);

        User::factory()->create([
            'email' => 'user4@szerveroldali.hu'
        ]);

        User::factory()->create([
            'email' => 'user5@szerveroldali.hu'
        ]);

        User::factory()->create([
            'email' => 'user6@szerveroldali.hu'
        ]);

        User::factory()->create([
            'email' => 'user5@szerveroldali.hu'
        ]);

        User::factory()->create([
            'email' => 'user7@szerveroldali.hu'
        ]);

        User::factory()->create([
            'email' => 'user8@szerveroldali.hu'
        ]);

        User::factory()->create([
            'email' => 'user9@szerveroldali.hu'
        ]);

        User::factory()->create([
            'email' => 'user10@szerveroldali.hu'
        ]);
    }
}
