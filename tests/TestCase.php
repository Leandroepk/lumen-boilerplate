<?php

namespace Tests;

use Artisan;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    public function migrate(array $migrations = [])
    {
        $path = database_path('migrations');
        $migrator = app()->make('migrator');
        $migrator->getRepository()->createRepository();
        $files = $migrator->getMigrationFiles($path);

        if (!empty($migrations)) {
            $files = collect($files)->filter(
                function ($value, $key) use ($migrations) {
                    if (in_array($key, $migrations)) {
                        return [$key => $value];
                    }
                }
            )->all();
        }

        $migrator->requireFiles($files);
        $migrator->runPending($files);
    }

    public function seed(string $seed = '')
    {
        $command = "db:seed";

        if (empty($seed)) {
            Artisan::call($command);
        } else {
            Artisan::call($command, ['--class' => $seed]);
        }
    }
}
