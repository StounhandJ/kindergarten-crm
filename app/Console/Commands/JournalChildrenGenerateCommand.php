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
        $children = Child::query()->lazy(100);
        $month = Carbon::now();
        foreach ($children as $child)
        {
            if (!GeneralJournalChild::getByChildAndMonth($child, $month)->exists)
            {
                $generalJournalChild = GeneralJournalChild::make($child, $month);
                $generalJournalChild->save();
            }
        }
        return 0;
    }
}
