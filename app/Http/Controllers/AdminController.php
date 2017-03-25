<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use DB;
use Validator;

class AdminController extends Controller
{
    public function orderList(Request $request)
    {
    	$output = (object)[]; // Output payload        
        try {            
        	$results = Order::where('is_finalized', true)->get();
        	foreach ($results as $result) {
        		$result->coupon = $result->coupon;
        		$result->shipment = $result->shipment;
        		$result->orderdedProducts = Db::table('ordered_products')
                    ->join('products', 'products.id', '=', 'ordered_products.product_id')
                    ->select('ordered_products.*', 'name', 'detail', 'price')
                    ->where('ordered_products.order_id', $result->id)
                    ->get();
        	}

            /* Writing Output */
            $output->status = 200;
            $output->message = "Success";
            $output->data = (object)[];
            $output->data->orders = $results;

            return json_encode($output);

        } catch (Exception $e) { // Syntax error/request fails
            $output->status = 500;
            $output->message = "Internal Service Error";
            return json_encode($output);
        }
    }

    public function unvalidatedOrderList(Request $request)
    {
    	$output = (object)[]; // Output payload        
        try {            
        	$results = Order::where('is_finalized', true)->where('is_validated', false)->get();
        	foreach ($results as $result) {
        		$result->coupon = $result->coupon;
        		$result->shipment = $result->shipment;
        		$result->orderdedProducts = Db::table('ordered_products')
                    ->join('products', 'products.id', '=', 'ordered_products.product_id')
                    ->select('ordered_products.*', 'name', 'detail', 'price')
                    ->where('ordered_products.order_id', $result->id)
                    ->get();
        	}

            /* Writing Output */
            $output->status = 200;
            $output->message = "Success";
            $output->data = (object)[];
            $output->data->orders = $results;

            return json_encode($output);

        } catch (Exception $e) { // Syntax error/request fails
            $output->status = 500;
            $output->message = "Internal Service Error";
            return json_encode($output);
        }
    }

    public function orderDetail(Request $request)
    {
    	$output = (object)[]; // Output payload        
        try {            
        	/* Input Validation */
            $validator = Validator::make($request->all(), [
                'orderId' => 'numeric|required'
            ]);

            if($validator->fails()) {  // Invalid input
                $output->status = 404;
                $output->message = "Not Found";
                return json_encode($output);
            }

        	$result = Order::find($request->orderId);
        	if($result){
        		$result->coupon = $result->coupon;
        		$result->shipment = $result->shipment;
        		$result->orderdedProducts = Db::table('ordered_products')
                    ->join('products', 'products.id', '=', 'ordered_products.product_id')
                    ->select('ordered_products.*', 'name', 'detail', 'price')
                    ->where('ordered_products.order_id', $result->id)
                    ->get();

	            /* Writing Output */
	            $output->status = 200;
	            $output->message = "Success";
	            $output->data = (object)[];
	            $output->data->orders = $result;

	            return json_encode($output);
	        }else{
	        	$output->status = 404;
	            $output->message = "Not Found";
	            return json_encode($output);
	        }

        } catch (Exception $e) { // Syntax error/request fails
            $output->status = 500;
            $output->message = "Internal Service Error";
            return json_encode($output);
        }
    }

    public function cancelOrder(Request $request)
    {
    	$output = (object)[]; // Output payload        
        try {            
        	/* Input Validation */
            $validator = Validator::make($request->all(), [
                'orderId' => 'numeric|required'
            ]);

            if($validator->fails()) {  // Invalid input
                $output->status = 404;
                $output->message = "Not Found";
                return json_encode($output);
            }

        	$result = Order::find($request->orderId);
        	if($result){
        		$result->is_validated = true;
        		$result->is_valid = false;
				$result->save();

	            /* Writing Output */
	            $output->status = 200;
	            $output->message = "Success";
	            return json_encode($output);
	        }else{
	        	$output->status = 404;
	            $output->message = "Not Found";
	            return json_encode($output);
	        }

        } catch (Exception $e) { // Syntax error/request fails
            $output->status = 500;
            $output->message = "Internal Service Error";
            return json_encode($output);
        }
    }

    public function shipOrder(Request $request)
    {
    	$output = (object)[]; // Output payload        
        try {            
        	/* Input Validation */
        	$messages = [
	            'required' => ':attribute is required.'
	        ];

            $validator = Validator::make($request->all(), [
                'orderId' => 'numeric|required',
                'noAwb' => 'string|required',                
                'shipmentTime' => 'string|required'
            ], $messages);

            if($validator->fails()) {  // Invalid input
            	$errors = $validator->errors()->all();
            	$stringMsg = '';
            	foreach ($errors as $error) {
            		$stringMsg .= " ".$error;
            	}

                $output->status = 404;
                $output->message = "Not Found. ".$stringMsg;
                return json_encode($output);
            }

            //create shipment
            $shipmentId = DB::table('shipments')->insertGetId([
                'no_awb' => $request->noAwb,
                'shipment_date' => date($request->shipmentTime)
            ]);
            if(!$shipmentId){
            	$output->status = 500;
	            $output->message = "Internal Service Error";
	            return json_encode($output);
            }

            //find order
        	$result = Order::find($request->orderId);
        	if($result){
            	//create shipment stat
            	DB::table('shipment_status')->insert([
            		'status_time' => date($request->shipmentTime),
	                'status' => 'SHIPMENT RECEIVED BY JNE COUNTER OFFICER AT [JAKARTA]',
	                'shipment_id' => $shipmentId
	            ]);

            	//update order
        		$result->is_shipped = true;
        		$result->shipment_id = $shipmentId;
				$result->save();

	            /* Writing Output */
	            $output->status = 200;
	            $output->message = "Success";
	            return json_encode($output);
	        }else{
	        	$output->status = 404;
	            $output->message = "Not Found";
	            return json_encode($output);
	        }

        } catch (Exception $e) { // Syntax error/request fails
            $output->status = 500;
            $output->message = "Internal Service Error";
            return json_encode($output);
        }
    }
}
