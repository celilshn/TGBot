<?php

namespace App\Console\Commands;


use App\Http\BusChecker;
use App\Models\RecordModel;
use Carbon\Carbon;
use DefStudio\Telegraph\Models\TelegraphBot;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckBuses extends Command
{
    protected $signature = "check:cron";
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        Log::debug("Time : $now->hour");

        $bot = TelegraphBot::find(5);
        $models = RecordModel::whereNot("range_start", null)->whereNot("range_end", null)->get();
        foreach ($models as $model) {
            Log::debug("Range Start : $model->range_start");
            Log::debug("Range End : $model->range_end");
            if ($now->hour >= $model->range_start && $now->hour < $model->range_end) {
                Log::debug("OK");
                $checker = new BusChecker();
                $data = $checker->data($model->durak_no);
                $json = json_decode($data);
                $parsedData = $this->parseData($json->data[0]->table);
                Log::debug("Parsed Data : $parsedData");
                $bot->chats()->where('chat_id', $model->chat_id)->first()->message($parsedData)->send();
            }
        }
    }

    private function parseData($table)
    {
        $str = "";
        foreach ($table as $item) {
            if ($item->arac_no !== "-")
                $str .= "$item->hat_kod - $item->sure \n";
        }

        return $str;
    }

}
