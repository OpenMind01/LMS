<?php

namespace Pi\Console\Commands;

use Illuminate\Console\Command;
use Schema;
use Symfony\Component\Console\Input\InputOption;
use Config;
use DB;

class MigrateReloadCommand extends Command
{
    protected $name = 'migrate:reload';
    protected $description = 'Drop All Tables Systematically.';

    public function handle()
    {
        if (!\App::environment('local') && !$this->option('force')) {
            $this->error('If you are not in a local environment, you must use the --force option.');

            return;
        }
        if (!\App::environment('production')) {
            $tables = DB::select('SHOW TABLES');
            $tables_in_database = 'Tables_in_' . Config::get('database.connections.mysql.database');
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            foreach ($tables as $table) {
                $tablesToSave = false;
                if (!$tablesToSave) {
                    Schema::drop($table->$tables_in_database);
                    $this->info('<info>Dropped: </info>' . $table->$tables_in_database);
                } else {
                    if ($table->$tables_in_database != 'points' && $table->$tables_in_database != 'messages') {
                        Schema::drop($table->$tables_in_database);
                        $this->info('<info>Dropped: </info>' . $table->$tables_in_database);
                    }
                }
            }

            exec('php artisan migrate --force -vvv', $migrateOutput);
            $this->info(implode("\n", $migrateOutput));
            $this->info('Migrated');
            exec('php artisan db:seed --force -vvv', $seedOutput);
            $this->info(implode("\n", $seedOutput));
            $this->info('Seeded');

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, true],
        ];
    }
}
