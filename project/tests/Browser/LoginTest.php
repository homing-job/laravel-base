<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use App\Models\User;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * ログインテスト
     *
     * @return void
     */
    public function testLogin()
    {
        $password = 'ranasoft';
        $user = User::factory()->create(['password' => Hash::make($password)]);
        
         $this->browse(function (Browser $browser) use ($user, $password) {
            $browser->visit('/login')
                ->type('#email', $user->email)
                ->type('#password', $password)
                ->press('ログイン')
                ->assertPathIs('/admin');
        });
    }
}
