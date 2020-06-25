<?php
/**
 * Created by IntelliJ IDEA.
 * User: alexburov
 * Date: 26.04.18
 * Time: 16:42
 */

namespace App\Console\Commands;
use Illuminate\Console\Command;

class Test extends Command
{
    protected $signature = 'cron:test';

    protected $description = 'Parse Email cron task';

    public function handle()
    {

        echo "Test class <br/>";
        //\Log::info('Test - '.\Carbon\Carbon::now());
    }
}