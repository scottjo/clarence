<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clarence:make-admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the is_admin flag for a user by email address';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("User with email [{$email}] not found.");

            return Command::FAILURE;
        }

        if ($user->is_admin) {
            $this->info("User [{$email}] is already an admin.");

            return Command::SUCCESS;
        }

        $user->is_admin = true;
        $user->save();

        $this->info("User [{$email}] has been granted admin access.");

        return Command::SUCCESS;
    }
}
