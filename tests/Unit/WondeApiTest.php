<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\CreatesApplication;

class WondeApiTest extends TestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        $this->createApplication();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_can_authenticate()
    {
        $client = app(\Wonde\Client::class);

        // For testing, we don't need the default 50 records, so supply the
        // per_page parameter.
        $this->assertNotEmpty($client->schools->all([], ['per_page' => 1]));
    }
}
