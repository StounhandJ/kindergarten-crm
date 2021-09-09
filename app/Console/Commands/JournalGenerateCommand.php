<?php

namespace App\Console\Commands;

use App\Models\Child;
use App\Models\GeneralJournalChild;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Output\ConsoleOutput;

class JournalGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'journal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Генерация ежемесячных журналов для детей и сотрудников';

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
        $this->call('journal:child');
        $this->call('journal:staff');
        return 0;
    }
}
