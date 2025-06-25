<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeIncidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('incident_types')->insert([
            ['name' => "Depôt sauvage d'ordures"],
            ['name' => "Panne d'éclairage public"],
            ['name' => "Nids-de-poule"],
            ['name' => "Fuite d'eau"],
            ['name' => "Problème d'égouts"],
            ['name' => "Signalisation défectueuse"],
            ['name' => "Feu de circulation en panne"],
            ['name' => "Pollution sonore"],
            ['name' => "Occupation illégale de trottoir"],
            ['name' => "Animaux errants"],
            ['name' => "Arbre tombé / dangereux"],
            ['name' => "Agression ou comportement suspect"],
            ['name' => "Voiture abandonnée"],
            ['name' => "Inondation"],
            ['name' => "Autre"],
        ]);
    }
}
