<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use App\Models\User;
use Tests\DuskTestCase;

class LogoutTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * ログアウトテスト
     *
     * @return void
     */
    public function testLogout()
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)->visit('/admin')
                ->click('#navbarDropdown')
                ->assertSee('ログアウト')
                ->clickLink('ログアウト');
            $browser->pause(1000);
            $browser->assertPathIs('/');
        });
    }
}
