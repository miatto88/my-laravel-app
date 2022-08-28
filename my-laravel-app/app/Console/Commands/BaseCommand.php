<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Log;

class BaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected function loggerInfo($action, $msg) {
        $log = sprintf( '[SendWeeklyAggregateTodo][batch][%s] %s',
            $action,
            $msg
        );
        Log::info($log);
    }

    protected function loggerError($action, $msg) {
        $log = sprintf( '[SendWeeklyAggregateTodo][batch][%s] %s',
            $action,
            $msg
        );
        Log::error($log);
    }

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
