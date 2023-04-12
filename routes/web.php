<?php

use App\Models\RecordModel;
use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use DefStudio\Telegraph\Models\TelegraphBot;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
$bot = TelegraphBot::fromId(5);
Route::get('/', function () use ($bot) {

});
Route::get('/request', function () {

    $client = new Client();

    $res = $client->request('GET', 'http://88.255.141.66/mblSrv14/service.asp?FNC=Otobusler&VER=3.1.0&LAN=tr&DURAK=10512', [
        'headers' => [
            'User-Agent' => 'EGO Genel Mudurlugu-EGO Cepte-3.1.0',
            'Content-Type' => ': application/json; charset=utf-8',
        ]
    ]);
    $data = $res->getBody()->getContents();

    dd();
    dd(str_replace("'", '"', $data));

});

Route::get('/request2', function () {
    $response = Http::withHeaders([
        'User-Agent' => 'EGO Genel Mudurlugu-EGO Cepte-3.1.0',
        'Content-Type' => 'text/html; charset=utf-8'
    ])->get('http://88.255.141.66/mblSrv14/service.asp?FNC=Otobusler&VER=3.1.0&LAN=tr&DURAK=10512');
    $data = $response->body();

    printf(str_replace("'", '"', $data));

});
Route::get('/send', function () use ($bot) {
    $chat = $bot->chats()->where('chat_id', 1262305861)->first();
    $chat->markdown("ss")->send();
    $chat->message('hello world')
        ->replyKeyboard(ReplyKeyboard::make()
            ->button('Send Contact')->requestContact()
            ->button('Send Location')->requestLocation()
            ->inputPlaceholder("Waiting for input...")
        )->send();
});

Route::get('/send', function () use ($bot) {
    $chat = $bot->chats()->where('chat_id', 1262305861)->first();
    $chat->message('hello world')
        ->keyboard(Keyboard::make()->buttons([
            Button::make("🗑️ Delete")->action("delete")->param('id', 12),
            Button::make("📖 Mark as Read")->action("read")->param('id', 13),
            Button::make("👀 Open")->url('https://test.it'),
        ])->chunk(2))->send();

});
