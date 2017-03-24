<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $output = (object)[]; // Output payload
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                $output->status = 401;
                $output->message = "Invalid email and password";
                return json_encode($output);
            }
        } catch (JWTException $e) {
            // something went wrong
            $output->status = 500;
            $output->message = "Internal Service Error";
            return json_encode($output);
        }

        // if no errors are encountered we can return a JWT
        $output->status = 200;
        $output->message = "Success";
        $output->token = compact('token');
        return json_encode($output);
    }
}
