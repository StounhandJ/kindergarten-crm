<?php

namespace App\Console\Commands;

use App\Models\Child;
use App\Models\GeneralJournalChild;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Storage::makeDirectory(now()->format("y-m-d H-i-s"));
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
