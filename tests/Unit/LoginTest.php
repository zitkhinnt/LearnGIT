<?php

    namespace Tests\Unit;

    use Tests\TestCase;
    use Illuminate\Foundation\Testing\WithFaker;
    use Illuminate\Foundation\Testing\RefreshDatabase;

    // require __DIR__.'/../../bootstrap/app.php';
    // include_once 'inc/db.php';

    class LoginTest extends TestCase
    {
        //setup and teardown functions
        // protected function setUp()
        // {
        //     parent::setUp();

        //     // $this->runDatabaseMigrations();
        //     // parent::createApplication();
        // }
        // protected function tearDown() { }

        /**
         * A basic unit test example.
         *
         * @return void
         */
        public function testExample()
        {
            $this->assertTrue(true);
        }

        public function testBasicTest()
        {
            $response = $this->get('/');
            $response->assertStatus(200);
            $response = $this->call('GET', '/');
            $this->assertEquals(200, $response->getStatusCode());
        }
    }
?>