<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{

    public function setUp() : void
    {
        parent::setUp();
        \Artisan::call('migrate');
    }
    
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();
        
        \Storage::fake("local");
        \Storage::fake("public");
        
        return $app;
    }
}
