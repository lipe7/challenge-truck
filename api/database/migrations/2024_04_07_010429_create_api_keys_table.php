<?php

use App\Domain\ApiStatus\ApiKey;
use Database\Seeders\ApiKeySeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const API_KEY_LENGTH = 40;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('api_keys', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->timestamps();
        });

        $seeder = new ApiKeySeeder();
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_keys');
    }

    private function generateApiKey($static = false)
    {
        if(!$static){
            $length = $this::API_KEY_LENGTH;
            return bin2hex(random_bytes($length / 2));
        }

        return '51be5348b9602834fbb67fb562bbd30c42b4c013';
    }
};
