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
        $this->info("Start create staff journal");

        $staffs = Staff::query()->lazy(100);
        $staff_count = Staff::query()->count();
        $month = Carbon::now();
        $count = 0;
        $progressBar = $this->output->createProgressBar();
        $progressBar->setFormat('verbose');
        $progressBar->start();
        foreach ($progressBar->iterate($staffs, $staff_count) as $staff)
        {
            if (!GeneralJournalStaff::getByChildAndMonth($staff, $month)->exists)
            {
                $generalJournalStaff = GeneralJournalStaff::make($staff, $month);
                $generalJournalStaff->save();
                $count+=1;
            }
        }
        $progressBar->finish();
        $this->newLine();

        $this->table(["Сотрудников всего", "Создано журналов на данный месяц"], [[$staff_count, $count]]);
        return 0;
    }
}
