<?php
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LinkTest extends TestCase {
    public function testWeSeeAListOfLinks() {
        factory(App\Link::class)->create([
            'title' => 'dotdev.co',
        ]);
        $this->visit('/')
            ->see('dotdev.co');
    }

    //test see form
    public function testWeSeeLinksForm() {
        $this->visit('/submit')
            ->see('Submit a link');
    }

    //test form validation
    public function testLinksFormValidation()
    {
        $this->visit('/submit')
        ->press('Submit')
        ->see('The title field is required')
        ->see('The url field is required')
        ->see('The description field is required');
    }

    //insert form to database
    public function testSubmitLinkToDb() {
        $this->visit('/submit')
            ->type('homestead', 'title')
            ->type('http://homestead.dev', 'url')
            ->type('Homestead URL', 'description')
            ->press('Submit')
            ->seeInDatabase('links', ['title' => 'homestead']);
    }
}
