<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use App\Models\User;
use Tests\DuskTestCase;

class NoLoginAccessTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * 未ログインアクセステスト
     *
     * @return void
     */
    public function testNoLoginAccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                    ->assertPathIs('/login');
        });
    }
}
