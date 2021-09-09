<?php

namespace App\Console\Commands;

use App\Models\Child;
use App\Models\GeneralJournalChild;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class JournalChildrenGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'journal:child';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Генерация ежемесячных журналов для детей';

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
        $this->info("Start create children journal");

        $children = Child::query()->lazy(100);
        $children_count = Child::query()->count();
        $month = Carbon::now();
        $count = 0;
        $progressBar = $this->output->createProgressBar();
        $progressBar->setFormat('verbose');
        $progressBar->start();

        foreach ($progressBar->iterate($children, $children_count) as $child)
        {
            if (!GeneralJournalChild::getByChildAndMonth($child, $month)->exists)
            {
                $generalJournalChild = GeneralJournalChild::make($child, $month);
                $generalJournalChild->save();
                $count+=1;
            }
        }
        $progressBar->finish();
        $this->newLine();

        $this->table(["Детей всего", "Создано журналов на данный месяц"], [[$children_count, $count]]);
        return 0;
    }
}
