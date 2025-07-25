<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ResponseFromatter;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $user = auth()->user();

        return ResponseFormatter::success($user->api_response);    
    }

    public function updateProfile()
    {
        $validator = \Validator::make(request()->all(), [
            'name' => 'required|min:2|max:100',
            'email' => 'nullable|email',
            'photo' => 'nullable|image|max:1024',
            'username' => 'nullable|min:2|max:20,',
            'phone' => 'nullable|numeric',
            'store_name' => 'nullable|min:2|max:100',
            'gender' => 'required|in:laki-laki,perempuan,lainnya',
            'birth_date' => 'nullable|date_format:Y-m-d ',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(
                400,
                $validator->errors());
        }

        $payload = $validator->validated();

        if(!is_null(request()->photo)) {
            $payload ['photo'] = request()->file('photo')->store(
                'user-photo', 'public'
            );
        } 

        auth()->user()->update($payload);

        return $this->getProfile() ;
    }
}
