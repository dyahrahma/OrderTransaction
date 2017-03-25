<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Product;
use App\OrderedProduct;
use App\Coupon;
use App\ShipmentStatus;
use App\Shipment;
use DB;
use Validator;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function addProduct(Request $request)
    {
    	$output = (object)[]; // Output payload        
        try {            
        	/* Input Validation */
        	$messages = [
	            'required' => ':attribute is required.',
	            'exists' => ':attribute not found',
	            'min' => ':attribute is minimal 1'
	        ];

            $validator = Validator::make($request->all(), [
                'productId' => 'numeric|required|exists:products,id',
                'quantity' => 'numeric|required|min:1'
            ], $messages);

            if($validator->fails()) {  // Invalid input
            	$errors = $validator->errors()->all();
            	$stringMsg = '';
            	foreach ($errors as $error) {
            		$stringMsg .= " ".$error;
            	}

                $output->status = 404;
                $output->message = $stringMsg;
                return json_encode($output);
            }

            $product = Product::find($request->productId);
            if($product->quantity < $request->quantity) {	//stock is not enough
                $output->status = 404;
                $output->message = "There is not enough stock for this product";
                return json_encode($output);
            }

            //find unsubmitted order belongs to the customer
            //if there is unsubmitted order, the product is added to this order
            //else create a new unsubmitted order for this customer
            $now = Carbon::now('Asia/Jakarta')->toDateTimeString();
    		$unsubmittedOrder = Order::updateOrCreate(
			    ['user_id' => $request->user()->id, 'is_finalized' => false],
			    ['date_order' => $now]
			);
			$orderedProduct = OrderedProduct::create([	'order_id' => $unsubmittedOrder->id,
										                'product_id' => $product->id,
										                'quantity' => $request->quantity,
										                'total_price' => $request->quantity * $product->price	]);

            if($orderedProduct){
	            $output->status = 200;
	            $output->message = "Success";
	            $output->data = (object)[];
		        $output->data->products = $this->getOrderedProducts($unsubmittedOrder->id);
	            return json_encode($output);
	        }else{
	        	$output->status = 500;
	            $output->message = "Internal Service Error";
	            return json_encode($output);
	        }

        } catch (Exception $e) { // Syntax error/request fails
            $output->status = 500;
            $output->message = "Internal Service Error";
            return json_encode($output);
        }
    }

    public function applyCoupon(Request $request)
    {
    	$output = (object)[]; // Output payload        
        try {            
        	/* Input Validation */
        	$messages = [
	            'required' => ':attribute is required.',
	            'exists' => ':attribute not found'
	        ];

            $validator = Validator::make($request->all(), [
                'orderId' => 'numeric|required|exists:orders,id',
                'coupon' => 'string|required|exists:coupons,code'
            ], $messages);

            if($validator->fails()) {  // Invalid input
            	$errors = $validator->errors()->all();
            	$stringMsg = '';
            	foreach ($errors as $error) {
            		$stringMsg .= " ".$error;
            	}

                $output->status = 404;
                $output->message = $stringMsg;
                return json_encode($output);
            }

            $coupon = Coupon::where('code', $request->coupon)->first();
            if($coupon->quantity < 1) {	
                $output->status = 404;
                $output->message = "Coupon code is not valid";
                return json_encode($output);
            }

            //save coupon
            $order = Order::find($request->orderId);
			$order->coupon_id = $coupon->id;
			$order->save();

            $output->status = 200;
            $output->message = "Success";
            $output->data = (object)[];
	        $output->data->coupon_code = $request->coupon;
	        $output->data->products = $this->getOrderedProducts($request->orderId);
            return json_encode($output);
        } catch (Exception $e) { // Syntax error/request fails
            $output->status = 500;
            $output->message = "Internal Service Error";
            return json_encode($output);
        }
    }
    
    public function submitOrder(Request $request)
    {
    	$output = (object)[]; // Output payload        
        try {            
        	/* Input Validation */
        	$messages = [
	            'required' => ':attribute is required.'
	        ];

            $validator = Validator::make($request->all(), [
                'orderId' => 'numeric|required|exists:orders,id',
                'useRegisteredData' =>'boolean|required'
            ], $messages);

            if($validator->fails()) {  // Invalid input
            	$errors = $validator->errors()->all();
            	$stringMsg = '';
            	foreach ($errors as $error) {
            		$stringMsg .= " ".$error;
            	}

                $output->status = 404;
                $output->message = $stringMsg;
                return json_encode($output);
            }

            $order = Order::find($request->orderId);
            //save data
            if($request->useRegisteredData){
            	$user = $request->user();

            	$order->name = $user->name;
        		$order->phone = $user->phone;
        		$order->email = $user->email;
        		$order->address = $user->address;
				// $order->save();
            }else if($request->name && $request->phone && $request->email && $request->address){
            	$order->name = $request->name;
        		$order->phone = $request->phone;
        		$order->email = $request->email;
        		$order->address = $request->address;
				// $order->save();
            }else{
            	$output->status = 404;
                $output->message = "name, phone, email, and address couldn't be empty.";
                return json_encode($output);
            }

            $orderedProducts = Db::table('ordered_products')
                    ->join('products', 'products.id', '=', 'ordered_products.product_id')
                    ->select('ordered_products.*', 'products.id as product_id')
                    ->where('ordered_products.order_id', $order->id)
                    ->get();

            $coupon;
            if($order->coupon_id){
            	$coupon = Coupon::find($order->coupon_id);
	            if($coupon) {
	            	if($coupon->quantity < 1){	
		                $output->status = 404;
		                $output->message = "Coupon code is not valid";
		                return json_encode($output);
		            }else{
		            	$coupon->quantity -= 1;
		            	$coupon->save();
		            }
	            }else{
	            	$output->status = 404;
	                $output->message = "Coupon code is not valid";
	                return json_encode($output);
	            }
            }

            if($orderedProducts){
            	$original_price = 0;
            	foreach ($orderedProducts as $orderedProduct) {
            		$product = Product::find($orderedProduct->product_id);
            		if($product->quantity >= $orderedProduct->quantity){
            			$product->quantity -= $orderedProduct->quantity;
            			$product->save();
            			$original_price += $orderedProduct->total_price;	//follow the price when product is added, not the current one
            		}else{
            			$output->status = 404;
			            $output->message = "Not enough stock for the product(s)";
			            return json_encode($output);
            		}
            	}

	            $order->original_price = $original_price;
	            $order->final_price = $original_price;
	    		//apply coupon (if there is any)
	    		if($order->coupon_id){
	    			if($coupon->is_nominal){
	    				$order->final_price -= $coupon->discount_nominal;
	    			}else{
	    				$order->final_price -= ($order->final_price * $coupon->discount_percentage / 100);
	    			}
	    			$order->final_price < 0 ? 0 : $order->final_price;
	    		}
	    		$now = Carbon::now('Asia/Jakarta')->toDateTimeString();
		        $order->is_finalized = true;
		        $order->finalizing_time = $now;
		        $order->save();

		        $result = Db::table('orders')
		        			->select('name', 'phone', 'email', 'address', 'original_price', 'final_price', 'finalizing_time')
		                    ->where('id', $order->id)
		                    ->first();
		        $result->ordered_products = $this->getOrderedProducts($order->id);
		        if($order->coupon_id){
			        $appliedCoupon = (object)[];
			        $appliedCoupon->code = $coupon->code;
			        if($coupon->is_nominal){
	    				$appliedCoupon->amount = $coupon->discount_nominal;
	    			}else{	    				
	    				$appliedCoupon->amount = $coupon->discount_percentage."%";
	    			}
	    			$result->coupon = $appliedCoupon;
			    }

		        $output->status = 200;
	            $output->message = "Success";
	            $output->data = (object)[];
		        $output->data = $result;
	            return json_encode($output);
	        }else{
	        	$output->status = 404;
                $output->message = "Not Found.";
                return json_encode($output);
	        }

        } catch (Exception $e) { // Syntax error/request fails
            $output->status = 500;
            $output->message = "Internal Service Error";
            return json_encode($output);
        }
    }

    public function submitPaymentProof(Request $request)
    {

    }
    
    public function checkOrderStatus(Request $request)
    {
    	$output = (object)[]; // Output payload        
        try {            
        	/* Input Validation */
        	$messages = [
	            'required' => ':attribute is required.',
	            'exists' => ':attribute not found'
	        ];

            $validator = Validator::make($request->all(), [
                'orderId' => 'numeric|required|exists:orders,id'
            ], $messages);

            if($validator->fails()) {  // Invalid input
            	$errors = $validator->errors()->all();
            	$stringMsg = '';
            	foreach ($errors as $error) {
            		$stringMsg .= " ".$error;
            	}

                $output->status = 404;
                $output->message = $stringMsg;
                return json_encode($output);
            }

            $order = Order::where('id',$request->orderId)->where('is_finalized', 1)->first();
            if(!$order){
            	$output->status = 404;
	            $output->message = "Not Found.";
	            return json_encode($output);
            }
			$result = (object)[];
			$result->sumbitted = $order->finalizing_time;
			if($order->is_validated){
				if($order->is_valid){
					$result->validated = $order->validating_time;
				}else{
					$result->canceled = $order->validating_time;
				}
			}
			if($order->is_shipped){
				$result->shipper = $order->shipping_time;
			}

            $output->status = 200;
            $output->message = "Success";
            $output->data = (object)[];
	        $output->data->status = $result;
            return json_encode($output);
        } catch (Exception $e) { // Syntax error/request fails
            $output->status = 500;
            $output->message = "Internal Service Error";
            return json_encode($output);
        }
    }
    
    public function checkShipmentStatus(Request $request)
    {
    	$output = (object)[]; // Output payload        
        try {            
        	/* Input Validation */
        	$messages = [
	            'required' => ':attribute is required.',
	            'exists' => ':attribute not found'
	        ];

            $validator = Validator::make($request->all(), [
                'shippingId' => 'string|required|exists:shipments,no_awb'
            ], $messages);

            if($validator->fails()) {  // Invalid input
            	$errors = $validator->errors()->all();
            	$stringMsg = '';
            	foreach ($errors as $error) {
            		$stringMsg .= " ".$error;
            	}

                $output->status = 404;
                $output->message = $stringMsg;
                return json_encode($output);
            }

            $shipment = Shipment::where('no_awb', $request->shippingId)->first();
            $shipmentStatus = ShipmentStatus::where('shipmentId', $shipment->id)->get();
            
            if($shipmentStatus){	            	
	            $output->status = 200;
	            $output->message = "Success";
	            $output->data = (object)[];
		        $output->data->status = $shipmentStatus;
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

    public function getOrderedProducts($orderId){
    	return DB::table('ordered_products')
		                    ->join('products', 'products.id', '=', 'ordered_products.product_id')
		                    ->select('name', 'detail', 'price', 'ordered_products.quantity', 'ordered_products.total_price')
		                    ->where('ordered_products.order_id', $orderId)
		                    ->get();
    }
}
