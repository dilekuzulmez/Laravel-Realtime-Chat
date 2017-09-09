<?php

namespace Tests\Browser;

use App\User;
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
    use DatabaseMigrations; 
    
    public function testBasicExample()
    {
        $user1 = factory(User::class)->create([
            'name' => 'Nezahat Doe'
        ]);

        $user2 = factory(User::class)->create([
            'name' => 'Dilek Doe'
        ]);

        $this->browse(function ($first, $second) use($user1, $user2) {
            $first->loginAs($user1)
                ->visit('http://localhost:8000/chat')
                ->waitFor('.chat-composer');
        
            $second->loginAs($user2)
                ->visit('http://localhost:8000/chat')
                ->waitFor('.chat-composer')
                ->type('#message', 'Hey Nezahat')
                ->press('Send');
        
            $first->waitForText('Hey Nezahat')
                ->assertSee('Dilek Doe');
        });
    }
    
    /*test1
        $this->browse(function (Browser $browser) {
            $browser->visit('http://localhost:8000/chat')
                    ->assertSee('Laravel');
        });
    */
}
