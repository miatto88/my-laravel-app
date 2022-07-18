<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App;
use App\Todo;
use App\User;
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\WeeklyAggreagateTodo;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:send_weekly-aggreagate-todo';

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
        $users = User::all();

        foreach ($users as $user) {
            echo $user['email'] . PHP_EOL;

            $newTasks = Todo::whereDate('created_at', '>', Carbon::today()->subday(7))
            ->where([
                ['user_id', '=', $user->id],
                ['deleted_at', '=', null],
            ])->count();

            $completeTasks = Todo::where([
                ['user_id', '=', $user->id],
                ['status', '=', 1],
            ])->count();
            
            $incompleteTasks = Todo::where([
                ['user_id', '=', $user->id],
                ['status', '=', 0],
            ])->count();

            Mail::to($user['email'])->send(new WeeklyAggreagateTodo($newTasks, $completeTasks, $incompleteTasks));
        }
        return 0;
    }
}
