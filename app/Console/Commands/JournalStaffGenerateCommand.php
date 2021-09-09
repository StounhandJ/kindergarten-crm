<?php

namespace App\Console\Commands;

use App\Models\GeneralJournalStaff;
use App\Models\Staff;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class JournalStaffGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'journal:staff';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Генерация ежемесячных журналов для сотрудников';

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
        $staffs = Staff::query()->lazy(100);
        $month = Carbon::now();
        foreach ($staffs as $staff)
        {
            if (!GeneralJournalStaff::getByChildAndMonth($staff, $month)->exists)
            {
                $generalJournalStaff = GeneralJournalStaff::make($staff, $month);
                $generalJournalStaff->save();
            }
        }
        return 0;
    }
}
