<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateFishHappyAdmin extends Command
{
    protected $signature = 'fishhappy:admin';

    protected $description = 'Create a Fish Happy admin account';

    public function handle(): int
    {
        $data = [
            'name' => $this->ask('Name'),
            'email' => $this->ask('Email'),
            'password' => $this->secret('Password'),
        ];
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:12', 'max:72'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                $this->error($message);
            }

            return self::FAILURE;
        }

        $user = new User($validator->validated());
        $user->role = User::ROLE_ADMIN;
        $user->save();
        $this->info('Admin account created.');

        return self::SUCCESS;
    }
}
