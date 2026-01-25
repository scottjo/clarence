<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class RemoveAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clarence:remove-admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the is_admin flag from a user by email address';

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

        if (! $user->is_admin) {
            $this->info("User [{$email}] is not an admin.");

            return Command::SUCCESS;
        }

        $user->is_admin = false;
        $user->save();

        $this->info("Admin access has been removed from user [{$email}].");

        return Command::SUCCESS;
    }
}
