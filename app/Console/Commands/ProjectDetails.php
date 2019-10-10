<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ProjectController;

class ProjectDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Projectnames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To insert dummy data in projects table';

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
     * @return mixed
     */
    public function handle()
    {
        $controller = new ProjectController(); // make sure to import the controller
        $controller->index();
    }
}
