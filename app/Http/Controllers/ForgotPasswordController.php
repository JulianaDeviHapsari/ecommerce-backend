<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ResponseFormatter;
use App\Models\User;    


class ForgotPasswordController extends Controller
{
     public function resendOtp()
    {
        $validator = \Validator::make(request()->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(
                400,
                $validator->errors()
            );
        }

        $otpRecord = \DB::table('password_reset_tokens')->where('email', request()->email)->first();
        // $user = User::where('email', request()->email)->whereNotNull('otp_register')->first();
        if (is_null($otpRecord)) {
            return ResponseFormatter::error(400, null, [
            'Request tidak ditemukan.'
        ]);
        }

        $check = \DB::table('password_reset_tokens')->where('email', request()->email)->count();

        if($check > 0 ) {
            return ResponseFormatter::error(400, null, [
                'Anda sudah melakukan ini , silahkan resend OTP.'
            ]);
        }

        do {
            $otp = rand(100000, 999999);

            $otpCount = \DB::table('password_reset_tokens')->where('token', $otp)->count();
        }while ($otpCount > 0);

        \DB::table('password_reset_tokens')->where('email', request()->email)->update([
            'token' => $otp
        ]);

        \Mail::to($user->email)->send( new \App\Mail\SendForgotPasswordOTP($user, $$otp));

        return ResponseFormatter::success([
            'is_sent' => true
        ]);

    }
    public function request()
    {
        $validator = \Validator::make(request()->all(), [
            'email' => 'required|email|exist:users,email'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(
                400,
                $validator->errors()
            );
        }

        do {
            $otp = rand(100000, 999999);

            $otpCount = \DB::table('password_reset_tokens')->where('token', $otp)->count();
        }while ($otpCount > 0);

       \DB::table('password_reset_tokens')->insert([
            'email' => request()->email,
            'password_reset_tokens' => $otp,
        ]);

        $user = User::whereEmail(request()->email)->firstOrFail();

        \Mail::to($user->email)->send( new \App\Mail\SendForgotPasswordOTP($user, $otp));

        return ResponseFormatter::success([
            'is_sent' => true
        ]); 
    }
    public function verifyOtp()
    {
        $validator = \Validator::make(request()->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|exists:password_reset_tokens,token'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(
                400,
                $validator->errors()
            );
        }

        $check = \DB::table('password_reset_tokens')->where('token', request()->otp)->where('email', request()->email)->count() ;

            if ($check >0) {
                return ResponseFormatter::success([
                    'is_correct' => true
                ]);
            } 
                return ResponseFormatter::error(
                    400,
                    'OTP tidak valid'
                );
            
    }
    public function resetPassword()
    {
         $validator = \Validator::make(request()->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|exists:password_reset_tokens,token',
            'password' => 'required|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(
                400,
                $validator->errors()
            );
        }

        $token = \DB::table('password_reset_tokens')->where('token', request()->otp)->where('email', request()->email)->first() ;

            if (!is_null($token)) {
                $user = User::where('email', request()->email)->first();
                $user->update([
                    'password' => bcrypt(request()->password)
                ]);

                \DB::table('password_reset_tokens')->where('token', request()->otp)->delete();

                $token = $user->createToken(config('app.namr'))->plainTextToken;

                return ResponseFormatter::success([
                    'access_token' => $token
                ]);

                return ResponseFormatter::error(
                    400,
                    'OTP tidak valid'
                );
    }
}
}
