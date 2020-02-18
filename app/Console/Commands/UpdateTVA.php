<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Tva;
class UpdateTVA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updatetva';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Chaque jour on vérifie si la tva n\'a pas changé avant de faire la MAJ ';

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
        $tva = TVA::all();

        dd ($tva);
    }
}
