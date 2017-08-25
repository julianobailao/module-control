<?php

namespace Tests\Traits;

use Illuminate\Foundation\Testing\DatabaseMigrations as BaseDatabaseMigrations;

trait DatabaseMigrations
{
    use BaseDatabaseMigrations {
        runDatabaseMigrations as protected traitMigrate;
    }
    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function runDatabaseMigrations()
    {
        $this->artisan('module:migrate');

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('module:migrate-rollback');
        });

        $this->traitMigrate();
    }
}
