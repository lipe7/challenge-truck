<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp();

        $this->withHeaders([
            'X-API-KEY' => env('API_KEY', '51be5348b9602834fbb67fb562bbd30c42b4c013')
        ]);
    }
}
