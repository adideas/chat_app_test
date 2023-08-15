<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Redis\Connectors\PhpRedisConnector;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class BasicAuthTest extends TestCase
{
    use RefreshDatabase;
    const USERNAME = 'php_api@unit.test';
    const PASSWORD = 'php_api@unit.test';

    public function test() {
        $user = User::create([
            'email' => self::USERNAME,
            'name' => self::USERNAME,
            'password' => $this->app->get('hash')->driver('bcrypt')->make(self::PASSWORD, [])
        ]);

        $url = 'unit_test_check_basic_auth_1';

        Route::get('unit_test_check_basic_auth_1', fn() => new Response([], 200))
            ->middleware('auth.basic');

        $this->get($url)->assertStatus(401);
        $this->withBasicAuth(self::USERNAME, self::PASSWORD)->get($url)->assertStatus(200);
        /** @var SessionManager $store */
        $store = App::get('session');
        //$store->regenerate(true);
        //$store->reflash();
        $store->regenerate(true);

        PhpRedisConnector::class;

        dd($store);
        $this->withoutToken()->withBasicAuth('', '')->get($url)->assertStatus(401);
    }
}
