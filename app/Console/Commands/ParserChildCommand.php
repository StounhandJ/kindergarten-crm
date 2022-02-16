<?php

namespace App\Console\Commands;

use App\Services\ParserChild;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ParserChildCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:child {path : path to the parsing file}';

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
        $path = $this->argument('path');
        if (Storage::exists($this->argument('path')))
            $path = Storage::path($this->argument('path'));

        ParserChild::parse($path);
        return 0;
    }
}
