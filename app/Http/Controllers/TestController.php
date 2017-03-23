<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function test(Request $request)
    {
        $output = (object)[]; // Output payload
        
        try {

            $output->status = 200;
            $output->message = "Success";
            return json_encode($output);

        } catch (Exception $e) { // Syntax error/request fails
            $output->status = 500;
            $output->message = "Internal server error. Please try again!";
            return json_encode($output);
        }
    }
}
