<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/testing', function () {
    dd(\Http::withHeaders([
        'key' => config('services.rajaongkir.key')
    ])->post(config('services.rajaongkir.base_url') . '/cost', [
        'origin'=>22,
        'destination'=>23, 
        'weight'=>1000,
        'courier'=> 'jne',
    ])->object());

    // $result = collect($response->object()->rajaongkir->result)->map(function($item) {
    //     return [
    //         'service' => $item->code,
    //         'description' => $item->description,
    //         'costs' => collect($item->costs)->map(function($cost) {
    //             return [
    //                 'value' => $cost->value,
    //                 'etd' => $cost->etd,
    //                 'note' => $cost->note,
    //             ];
    //         }),
    //     ];
    // });

    // dd(result);
});

// Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransController::class, 'callback']);
