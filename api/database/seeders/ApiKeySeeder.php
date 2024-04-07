<?php

namespace Database\Seeders;

use App\Domain\ApiStatus\ApiKey;
use Illuminate\Database\Seeder;

class ApiKeySeeder extends Seeder
{
    const API_KEY_LENGTH = 40;

    /**
     * Run the database seeds.
     */
    public function run()
    {
        if (!ApiKey::first()) {
            $apiKey = $this->generateApiKey(true);
            ApiKey::create([
                'key' => $apiKey
            ]);
        }

    }

    private function generateApiKey($static = false)
    {
        if(!$static){
            $length = $this::API_KEY_LENGTH;
            return bin2hex(random_bytes($length / 2));
        }

        return '51be5348b9602834fbb67fb562bbd30c42b4c013';
    }


}
