<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/customer/login')
                    ->type('email', 'prashant@webkul.com')
                    ->type('password', '12345678')
                    ->click('input[type="submit"]')
                    ->screenshot('error');
        });
    }
}
