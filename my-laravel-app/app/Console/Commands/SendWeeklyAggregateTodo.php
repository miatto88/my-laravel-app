<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\BaseCommand;
use App;
use App\Todo;
use App\User;
// use App\aggregate;
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\WeeklyaggregateTodo;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendEmails extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:send_weekly-aggregate-todo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send e-mails to active users';

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
        $this->loggerInfo('run', 'start');

        $users = User::all();
        $successCount = 0;
        $failedCount = 0;

        foreach ($users as $user) {
            // echo $user['email'] . PHP_EOL;

            $newTaskCount = Todo::whereDate('created_at', '>', Carbon::today()->subday(7))
            ->where([
                ['user_id', '=', $user->id],
                ['deleted_at', '=', null],
            ])->count();

            $completeTaskCount = Todo::where([
                ['user_id', '=', $user->id],
                ['status', '=', 1],
            ])->count();
            
            $incompleteTaskCount = Todo::where([
                ['user_id', '=', $user->id],
                ['status', '=', 0],
            ])->count();

            DB::beginTransaction();
            try {
                $aggregate = $user->aggregate;
                $aggregate->aggregate_new_task_count = $newTaskCount;
                $aggregate->aggregate_complete_task_count = $completeTaskCount;
                $aggregate->aggregate_incomplete_task_count = $incompleteTaskCount;
                // throw new \Exception("DBエラー");
                $aggregate->save();
                DB::commit();
                $this->loggerInfo('send seccess', $user->email);
            } catch (\Exception $e) {
                $errorLog = sprintf( '%s user_id: %s stack trace: %s %s',
                    'failed to update aggregates.',
                    $user->id,
                    $e->getFile(),
                    $e->getLine()
                );
                $this->loggerError('execption error', $errorLog);
                $failedCount++;
    
                DB::rollback();
            }

            try {
                Mail::to($user['email'])->send(new WeeklyaggregateTodo($newTaskCount, $completeTaskCount, $incompleteTaskCount));
                if( empty(Mail::failures()) ) {
                    $successCount++;
                } else {
                    $failedCount++;
                }
            } catch (\Exception $e)  {
                $errorLog = sprintf( '%s user_id: %s stack trace: %s %s',
                    'failed to send mail.',
                    $user->id,
                    $e->getFile(),
                    $e->getLine()
                );
                $this->loggerError('execption error', $errorLog);
                $failedCount++;
    
                DB::rollback();
            }
        }

        $completeLog = sprintf('success: %s failed: %s',
            $successCount,
            $failedCount
        );
        $this->loggerInfo('complete', $completeLog);
    }
}
