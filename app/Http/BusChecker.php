<?php

namespace App\Http;

use App\Models\RecordModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BusChecker
{
    function data($durak_no): string
    {

        $response = Http::withHeaders([
            'User-Agent' => 'EGO Genel Mudurlugu-EGO Cepte-3.1.0',
            'Content-Type' => 'application/json;charset=UTF-8',
            'Charset' => 'utf-8',
        ])->get('http://88.255.141.66/mblSrv14/service.asp?FNC=Otobusler&VER=3.1.0&LAN=tr&DURAK=' . $durak_no);
        $data = $response->body();
        Log::debug("Data : $data");
        $replaced = str_replace("'", '"', $data);
        return  utf8_decode($replaced);

    }

    public static function convert_from_latin1_to_utf8_recursively($dat)
    {
        if (is_string($dat)) {
            return utf8_encode($dat);
        } elseif (is_array($dat)) {
            $ret = [];
            foreach ($dat as $i => $d) $ret[$i] = self::convert_from_latin1_to_utf8_recursively($d);

            return $ret;
        } elseif (is_object($dat)) {
            foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

            return $dat;
        } else {
            return $dat;
        }
    }
// Sample use
// Just pass your array or string and the UTF8 encode will be fixed
}
