<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Person;
// require_once 'Person.php';

class PersonTest extends TestCase
{
    public $test;
    
    public function setUp()
    {
        $this->test = new Person('Khanh');
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testName()
    {
        $name = $this->test->getName();
        $this->assertFalse($name=='Khanh');

        $this->assertTrue(true);
    }
}
