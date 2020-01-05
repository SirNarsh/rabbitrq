<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class AppInfoTest extends TestCase
{
    /**
     * Check if AppInfoTest works correctly
     * AppInfoTest has three jobs:
     *  - Simply make sure frontend can connect to API
     *  - Expose name, debug, env config vars to App
     *  - Return if app has no users 'no_users' so the App redirect first user to setup page
     * @return void
     */
    public function testAppInfo()
    {
        Config::set('app.name', 'AppName');
        Config::set('app.debug', false);
        Config::set('app.env', 'production');

        $response = $this->getJson('info');

        $response->assertStatus(200);
        $responseArray = json_decode($response->getContent(), true);
        $this->assertEquals(
            [
                'name' => 'AppName',
                'debug' => false,
                'env' => 'production',
                'no_users' => true,
            ],
            $responseArray
        );

        factory(User::class, 1)->create(); // Create first user to change no_users response to true
        Config::set('app.env', 'testing');
        Config::set('app.debug', true);

        $response = $this->getJson('info');

        $response->assertStatus(200);
        $responseArray = json_decode($response->getContent(), true);
        $this->assertEquals(
            [
                'name' => 'AppName',
                'debug' => true,
                'env' => 'testing',
                'no_users' => false,
            ],
            $responseArray
        );
    }
}
