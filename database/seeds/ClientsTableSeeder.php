<?php

use App\Client;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = [
            ['name' => 'Client Demo 1'],
            ['name' => 'Client Demo 2'],
            ['name' => 'Client Demo 3'],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }

    }
}
