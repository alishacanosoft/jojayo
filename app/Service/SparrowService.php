<?php

namespace App\Service;

use GuzzleHttp\Client;

class SparrowService
{
    static public function sendSms(array $numbers, $message)
    {
        $to_numbers = null;
        foreach ($numbers as $number) {
            $to_numbers .= $number . ',';
        }
        $to_numbers = rtrim($to_numbers, ',');
        $http = new Client();
        try {
            $response = $http->get(config('app.sparrow_url'), [
                'query' => [
                    'token' => 'cdKlsNCZZ0oSTLMMylIC',
                    'from' => 'Jojayo',
                    'to' => $to_numbers,
                    'text' => $message
                ],
                'http_errors' => false
            ]);

            return response()->json(['token' => json_decode((string) $response->getBody())]);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return $e;
        }
    }
}