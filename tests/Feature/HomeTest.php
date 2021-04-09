<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    public function testHomePage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeText('Hello, Laravel!');
    }

    public function testContactPage()
    {
        $response = $this->get('/contact');

        $response->assertSeeText('Contact Page');
    }
}
