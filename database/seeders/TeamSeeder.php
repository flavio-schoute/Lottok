<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Team::factory()->create([
            'name' => 'Ajax'
        ]);

        Team::factory()->create([
            'name' => 'PSV'
        ]);

        Team::factory()->create([
            'name' => 'Feyenoord'
        ]);

        Team::factory()->create([
            'name' => 'AZ'
        ]);

        Team::factory()->create([
            'name' => 'Willem II'
        ]);

        Team::factory()->create([
            'name' => 'N.E.C. Nijmegen'
        ]);

        Team::factory()->create([
            'name' => 'RKC Waalwijk'
        ]);

        Team::factory()->create([
            'name' => 'SC Cambuur'
        ]);

        Team::factory()->create([
            'name' => 'PEC Zwolle'
        ]);
    }
}
