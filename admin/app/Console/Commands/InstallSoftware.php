<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Api\v1\User\Models\User;


class InstallSoftware extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:pos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is to install software';

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
        $this->createSuperAdmin();
    }

    private function createSuperAdmin()
    {
        try
        {
            $user=new User();
            $user->first_name='super';
            $user->last_name='admin';
            $user->user_type='superadmin';
            $user->email='admin@gmail.com';
            $user->phone='01912926554';
            $user->password=bcrypt('123456');
            $user->is_active='Yes';
            $user->save();
            $this->info("Superadmin has been created");
            $this->info("User:admin@gmail.com");
            $this->info("Password:123456");
        }
        catch(\Exception $e)
        {
            $this->info($e->getMessage());
        }
    }
}
