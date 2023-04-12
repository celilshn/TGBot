<?php

namespace App\Http\Webhooks;

use App\Models\RecordModel;
use Illuminate\Support\Stringable;

class MyHandler extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    protected function handleChatMessage(Stringable $text): void
    {
        // in this example, a received message is sent back to the chat
        $this->chat->html("Received: $text")->send();
    }

    public function durak($input)
    {
        $chat_id = $this->chat->chat_id;

        // try {
        //     $model = new RecordModel();
        //     $model->chat_id = $chat_id;
        //     $model->durak_no = $input;
        //     $model->save();
        // } catch (\Exception $e) {
        //     $this->chat->message("input :" . $e->getMessage())->send();
        // }
        try {

            if (empty($input) || $input == "/" . __FUNCTION__)
                return $this->chat->message("Empty")->send();
            $model = RecordModel::where('chat_id', $chat_id)->firstOrCreate();
            $model->durak_no = $input;
            $model->chat_id = $chat_id;

            $this->chat->message($model->save())->send();
        } catch (\Exception $e) {
            $this->chat->message($e->getMessage())->send();

        }
    }

    public function period($input)
    {
        $chat_id = $this->chat->chat_id;
        $this->chat->message("input : $input")->send();
        if (empty($input) || $input == "/" . __FUNCTION__)
            return $this->chat->message("Empty")->send();

        $model = RecordModel::where('chat_id', $chat_id)->firstOrCreate();
        $model->period = $input;
        $model->save();
    }

    public function aralik($input)
    {
        try {
            $chat_id = $this->chat->chat_id;
            $this->chat->message("input : $input")->send();
            if (empty($input) || $input == "/" . __FUNCTION__)
                $this->chat->message("Empty")->send();
            else {
                $array = explode("-",$input );
                $model = RecordModel::where('chat_id', $chat_id)->firstOrCreate();
                $model->chat_id = $chat_id;
                $model->range_start = $array[0];
                $model->range_end = $array[1];
                $this->chat->message($model->save())->send();
            }
        } catch (\Exception $e) {
            $this->chat->message($e->getMessage())->send();

        }
    }

    public function hat($userName)
    {
        if (!empty($userName))
            $this->chat->markdown("*Hi* $userName, happy to be here!")->send();
        else
            $this->chat->markdown("*Hi* stranger, happy to be here!")->send();
    }

    public function hi($userName)
    {
        if (!empty($userName))
            $this->chat->markdown("*Hi* $userName, happy to be here!")->send();
        else
            $this->chat->markdown("*Hi* stranger, happy to be here!")->send();
    }

    public function start()
    {
        $chat_id = $this->chat->chat_id;
        $this->chat->markdown("*Hi* stranger, happy to be here! $chat_id")->send();

    }


    protected function handleUnknownCommand(Stringable $text): void
    {
        $this->chat->html("I can't understand your command: $text")->send();
    }
}
