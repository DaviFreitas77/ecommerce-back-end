<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\WelcomeToSite;
use Illuminate\Console\Command;

class sendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::all()->each(fn(User $user)=>$user->notify(new WelcomeToSite));
    }
}