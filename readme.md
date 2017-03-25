This project is available and can be accessed at <a href="https://frozen-bastion-68983.herokuapp.com/api/">https://frozen-bastion-68983.herokuapp.com/api/ </a>

---------------------------------------------
# Daftar API yang tersedia

## POST [ /authentication]
Melakukan login untuk memperoleh token yang akan digunakan dalam mengakses API selanjutnya

+ Parameters
    + email - email pengguna
    + password - password pengguna

+ Example Request
    + Login Customer
   		`https://frozen-bastion-68983.herokuapp.com/api/authenticate`
   		body:
   		{
			"email": "dyah.rahma777@gmail.com",
			"password": "dyah123"
   		}

    + Login Admin
   		`https://frozen-bastion-68983.herokuapp.com/api/authenticate`
   		body:
   		{
			"email": "dyraw777@gmail.com",
			"password": "dyah123"
		}

+ Response 200    
        {
			"status": 200,
			"message": "Success",
			"token": {
					    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTQ5MDQ1NzM3NSwiZXhwIjoxNDkxMDYyMTc1LCJuYmYiOjE0OTA0NTczNzUsImp0aSI6ImE5Nzk0NmFhZWY5YzRhYzBiNWU0NjFkYjBlOWIwZTE1In0.q9GrQNlV0w6AAulD6IkXb9pjAFcCf0sBn-01qtWjxrI"
				    }
        }

+ Response 401
        {
            "status": 401,
 			 "message": "Invalid email and password"
        }
    
+ Response 500
        {
            "status": 500,
            "message": "Internal Service Error"
        }

---------------------------------------------
#### Untuk dapat menggunakan API di bawah ini, token yang didapat dari proses login harus ditambahkan pada header request.
#### Pada header tambahkan:
#### Authorization -> Bearer "token_yang_diperoleh"
#### contoh:
#### Authorization -> Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTQ5MDQ0MjE0MiwiZXhwIjoxNDkxMDQ2OTQyLCJuYmYiOjE0OTA0NDIxNDIsImp0aSI6IjJhYmZmN2VlNjdmMThlMjgxMTk1YWE2ZjQwY2ZmZDM0In0.mPAAF22hsTv4opH9vqmKzz_CcpjjiUeepor-ZUwXzJs
---------------------------------------------

## API untuk Customer -> hanya bisa diakses menggunakan token hasil login sebagai customer

### GET [ /addProduct]
Melakukan penambahan produk pada order

+ Parameters
    + productId - id produk yg akan ditambahkan
    + quantity - banyaknya produk yg akan ditambahkan

+ Example Request
    `https://frozen-bastion-68983.herokuapp.com/api/addProduct?productId=1&quantity=3`

+ Response 200    
        {
		  	"status": 200,
		  	"message": "Success",
		  	"data": {
		    	"products": [
			      	{
				        "name": "Xiaomi Mi Note 2",
				        "detail": "5.7 Inch, Snapdragon 821 quad core CPU, 6GB RAM, 128GB ROM, 22.5MP rear + 8MP front dual camera, Android 6.0 OS.",
				        "price": 6899000,
				        "quantity": 3,
				        "total_price": 20697000
			      	}
	    		]
	  		}
		}

+ Response 404
        {
		 	"status": 404,
			"message": "There is not enough stock for this product"
		}
    
+ Response 500
        {
            "status": 500,
            "message": "Internal Service Error"
        }

### GET [ /applyCoupon]
Memasukkan kupon pada order, namun tidak langsung dilakukan pengurangan harga

+ Parameters
    + orderId - id order yg ingin diberi kupon
    + coupon - kode kupon yang ingin ditambahkan

+ Example Request
    `https://frozen-bastion-68983.herokuapp.com/api/applyCoupon?orderId=4&coupon=MARCH10`

+ Response 200    
        {
			"status": 200,
			"message": "Success",
			"data": {
				"coupon_code": "MARCH10",
				"products": [
				  	{
					    "name": "Xiaomi Mi Note 2",
					    "detail": "5.7 Inch, Snapdragon 821 quad core CPU, 6GB RAM, 128GB ROM, 22.5MP rear + 8MP front dual camera, Android 6.0 OS.",
					    "price": 6899000,
					    "quantity": 3,
					    "total_price": 20697000
				  	}
				]
			}
		}

+ Response 404
        {
		  	"status": 404,
		  	"message": " coupon not found"
		}
    
+ Response 500
        {
            "status": 500,
            "message": "Internal Service Error"
        }

### POST [ /submitOrder]
Melakukan finalisasi order dengan memasukkan data diri yang dapat diambil dari data saat registrasi atau dengan memasukkan data baru

+ Parameters
    + orderId - id order yg ingin diberi kupon
    + useRegisteredData (true/false) - true jika menggunakan data yang tersimpan, false jika ingin memasukkan data baru
    + name, phone, email, address jika useRegisteredData == false

+ Example Request
    `https://frozen-bastion-68983.herokuapp.com/api/submitOrder
    body:
    {
	  	"orderId": 4,
	  	"useRegisteredData": false,
	  	"name": "dyah",
	  	"phone": "08123456789",
	  	"email": "dyah@gmail.com",
	  	"address": "Bandung 40132"
	}	

+ Response 200    
        {
		  	"status": 200,
		  	"message": "Success",
		  	"data": {
			    "name": "dyah",
			    "phone": "08123456789",
			    "email": "dyah@gmail.com",
			    "address": "Bandung 40132",
			    "original_price": 20697000,
			    "final_price": 18627300,
			    "finalizing_time": "2017-03-25 23:43:20",
			    "ordered_products": [
				      {
				        "name": "Xiaomi Mi Note 2",
				        "detail": "5.7 Inch, Snapdragon 821 quad core CPU, 6GB RAM, 128GB ROM, 22.5MP rear + 8MP front dual camera, Android 6.0 OS.",
				        "price": 6899000,
				        "quantity": 3,
				        "total_price": 20697000
				      }
			    ],
			    "coupon": {
			      	"code": "MARCH10",
			      	"amount": "10.00%"
			    }
		  	}
		}

+ Response 404
        {
		  	"status": 404,
		  	"message": " coupon not found"
		}
    
+ Response 500
        {
            "status": 500,
            "message": "Internal Service Error"
        }

### GET [ /checkOrderStatus]
Melakukan penambahan produk pada order

+ Parameters
    + orderId - id order yang akan dicek

+ Example Request
    `https://frozen-bastion-68983.herokuapp.com/api/checkOrderStatus?orderId=1`

+ Response 200    
        {
		  	"status": 200,
		  	"message": "Success",
		  	"data": {
		    	"status": {
		      		"sumbitted": 2017-03-23 11:00:00,
		      		"validated": "2017-03-23 13:00:00",
		      		"shipper": "2017-03-23 20:33:00"
		    	}
		  	}
		}

+ Response 404
        {
		 	"status": 404,
			"message": "Not Found."
		}
    
+ Response 500
        {
            "status": 500,
            "message": "Internal Service Error"
        }

### GET [ /checkShipmentStatus]
Melakukan pengecekan status pengiriman

+ Parameters
    + shippingId - nomor pengiriman

+ Example Request
    `https://frozen-bastion-68983.herokuapp.com/api/checkShipmentStatus?shippingId=01067105501317`

+ Response 200    
{
  	"status": 200,
  	"message": "Success",
  	"data": {
    "status": [
      	{
	        "id": 1,
	        "status_time": "2017-03-23 20:33:00",
	        "status": "SHIPMENT RECEIVED BY JNE COUNTER OFFICER AT [JAKARTA]",
	        "shipment_id": 1,
	        "created_at": null,
	        "updated_at": null
      	},
      	{
	        "id": 2,
	        "status_time": "2017-03-23 21:37:00",
	        "status": "RECEIVED AT SORTING CENTER [JAKARTA]",
	        "shipment_id": 1,
	        "created_at": null,
	        "updated_at": null
      	},
      	{
	        "id": 3,
	        "status_time": "2017-03-23 22:04:00",
	        "status": "PROCESSED AT SORTING CENTER [JAKARTA]",
	        "shipment_id": 1,
	        "created_at": null,
	        "updated_at": null
      	},
      	{
	        "id": 4,
	        "status_time": "2017-03-23 23:11:00",
	        "status": "SHIPMENT PICKED UP BY JNE COURIER [JAKARTA]",
	        "shipment_id": 1,
	        "created_at": null,
	        "updated_at": null
      	},
      	{
	        "id": 5,
	        "status_time": "2017-03-24 06:15:00",
	        "status": "DEPARTED FROM TRANSIT [GATEWAY, BANDUNG]",
	        "shipment_id": 1,
	        "created_at": null,
	        "updated_at": null
      	},
      	{
	        "id": 6,
	        "status_time": "2017-03-24 08:11:00",
	        "status": "RECEIVED AT WAREHOUSE [BANDUNG]",
	        "shipment_id": 1,
	        "created_at": null,
	        "updated_at": null
      	},
      	{
	        "id": 7,
	        "status_time": "2017-03-24 14:17:00",
	        "status": "WITH DELIVERY COURIER [BANDUNG]",
	        "shipment_id": 1,
	        "created_at": null,
	        "updated_at": null
      	},
      	{
	        "id": 8,
	        "status_time": "2017-03-24 19:15:00",
	        "status": "DELIVERED TO [RAHMA | 12-03-2017 19:03 ]",
	        "shipment_id": 1,
	        "created_at": null,
	        "updated_at": null
      	}
	]
}

+ Response 404
        {
		 	"status": 404,
			"message": "Not Found."
		}
    
+ Response 500
        {
            "status": 500,
            "message": "Internal Service Error"
        }

## API untuk Admin -> hanya bisa diakses menggunakan token hasil login sebagai admin

### GET [ /orderList]
Menampilkan semua order yang telah disubmit

+ Example Request
    `https://frozen-bastion-68983.herokuapp.com/api/orderList`

+ Response 200    
{
  "status": 200,
  "message": "Success",
  "data": {
    "orders": [
      {
        "id": 1,
        "user_id": 2,
        "coupon_id": 1,
        "shipment_id": 1,
        "is_finalized": 1,
        "name": "customer dyah rahma",
        "phone": "085716661493",
        "email": "dyah.rahma777@gmail.com",
        "address": "Jl Pelesiran 81A/56",
        "original_price": 7200000,
        "final_price": 7150000,
        "payment_proof_path": "/images/payment/1.jpg",
        "is_validated": 1,
        "is_valid": 1,
        "is_shipped": 1,
        "date_order": "2017-03-23 00:00:00",
        "finalizing_time": "2017-03-23 11:00:00",
        "validating_time": "2017-03-23 13:00:00",
        "shipping_time": "2017-03-23 20:33:00",
        "created_at": null,
        "updated_at": null,
        "coupon": {
          "id": 1,
          "code": "PROMO50K",
          "is_nominal": 1,
          "discount_nominal": 50000,
          "discount_percentage": "0.00",
          "start_date": "2017-01-01",
          "expired_date": "2017-05-01",
          "quantity": 15,
          "created_at": null,
          "updated_at": null
        },
        "shipment": {
          "id": 1,
          "no_awb": "01067105501317",
          "shipment_date": "2017-03-23",
          "created_at": null,
          "updated_at": null
        },
        "orderdedProducts": [
          {
            "id": 1,
            "order_id": 1,
            "product_id": 4,
            "quantity": 2,
            "total_price": 3000000,
            "created_at": null,
            "updated_at": null,
            "name": "Xiaomi Redmi 4A",
            "detail": "RAM 2 GB, internal 16 GB, prosesor Snapdragon 425",
            "price": 1500000
          },
          {
            "id": 2,
            "order_id": 1,
            "product_id": 5,
            "quantity": 1,
            "total_price": 4200000,
            "created_at": null,
            "updated_at": null,
            "name": "Xiaomi Mi 5s",
            "detail": "Internal 64 GB, 3 GB RAM, Versi OS Android OS, v6.0 (Marshmallow), Jenis CPU Qualcomm MSM8996 Snapdragon 821 CPU Quad-core, GPU Adreno 530",
            "price": 4200000
          }
        ]
      },
      {
        "id": 2,
        "user_id": 2,
        "coupon_id": 2,
        "shipment_id": 2,
        "is_finalized": 1,
        "name": "test user",
        "phone": "081111111111",
        "email": "111@11.com",
        "address": "Jl A 1",
        "original_price": 1900000,
        "final_price": 1710000,
        "payment_proof_path": "/images/payment/2.jpg",
        "is_validated": 1,
        "is_valid": 1,
        "is_shipped": 1,
        "date_order": "2017-03-25 00:00:00",
        "finalizing_time": "2017-03-25 10:00:00",
        "validating_time": "2017-03-25 14:00:00",
        "shipping_time": "2017-03-25 18:15:00",
        "created_at": null,
        "updated_at": null,
        "coupon": {
          "id": 2,
          "code": "MARCH10",
          "is_nominal": 0,
          "discount_nominal": 0,
          "discount_percentage": "10.00",
          "start_date": "2017-01-01",
          "expired_date": "2017-05-01",
          "quantity": 1,
          "created_at": null,
          "updated_at": "2017-03-25 16:45:30"
        },
        "shipment": {
          "id": 2,
          "no_awb": "00351107667777",
          "shipment_date": "2017-03-25",
          "created_at": null,
          "updated_at": null
        },
        "orderdedProducts": [
          {
            "id": 3,
            "order_id": 2,
            "product_id": 3,
            "quantity": 1,
            "total_price": 1900000,
            "created_at": null,
            "updated_at": null,
            "name": "Xiaomi Redmi 4 Prime",
            "detail": "RAM 3 GB, memori internal 32 GB, prosesor Snapdragon 625 dan resolusi layar 1080 x 1920 pixels",
            "price": 1900000
          }
        ]
      },
      {
        "id": 4,
        "user_id": 2,
        "coupon_id": 2,
        "shipment_id": null,
        "is_finalized": 1,
        "name": "dyah",
        "phone": "08123456789",
        "email": "dyah@gmail.com",
        "address": "Bandung 40132",
        "original_price": 20697000,
        "final_price": 18627300,
        "payment_proof_path": null,
        "is_validated": 0,
        "is_valid": 0,
        "is_shipped": 0,
        "date_order": "2017-03-25 23:13:45",
        "finalizing_time": "2017-03-25 23:45:30",
        "validating_time": null,
        "shipping_time": null,
        "created_at": "2017-03-25 16:13:45",
        "updated_at": "2017-03-25 16:45:30",
        "coupon": {
          "id": 2,
          "code": "MARCH10",
          "is_nominal": 0,
          "discount_nominal": 0,
          "discount_percentage": "10.00",
          "start_date": "2017-01-01",
          "expired_date": "2017-05-01",
          "quantity": 1,
          "created_at": null,
          "updated_at": "2017-03-25 16:45:30"
        },
        "shipment": null,
        "orderdedProducts": [
          {
            "id": 5,
            "order_id": 4,
            "product_id": 1,
            "quantity": 3,
            "total_price": 20697000,
            "created_at": "2017-03-25 16:13:45",
            "updated_at": "2017-03-25 16:13:45",
            "name": "Xiaomi Mi Note 2",
            "detail": "5.7 Inch, Snapdragon 821 quad core CPU, 6GB RAM, 128GB ROM, 22.5MP rear + 8MP front dual camera, Android 6.0 OS.",
            "price": 6899000
          }
        ]
      }
    ]
  }
}

+ Response 500
        {
            "status": 500,
            "message": "Internal Service Error"
        }

### GET [ /unvalidatedOrderList]
Menampilkan order yang telah disubmit namun belum divalidasi oleh admin

+ Example Request
    `https://frozen-bastion-68983.herokuapp.com/api/unvalidatedOrderList`

+ Response 200    
{
  "status": 200,
  "message": "Success",
  "data": {
    "orders": [
      {
        "id": 4,
        "user_id": 2,
        "coupon_id": 2,
        "shipment_id": null,
        "is_finalized": 1,
        "name": "dyah",
        "phone": "08123456789",
        "email": "dyah@gmail.com",
        "address": "Bandung 40132",
        "original_price": 20697000,
        "final_price": 18627300,
        "payment_proof_path": null,
        "is_validated": 0,
        "is_valid": 0,
        "is_shipped": 0,
        "date_order": "2017-03-25 23:13:45",
        "finalizing_time": "2017-03-25 23:45:30",
        "validating_time": null,
        "shipping_time": null,
        "created_at": "2017-03-25 16:13:45",
        "updated_at": "2017-03-25 16:45:30",
        "coupon": {
          "id": 2,
          "code": "MARCH10",
          "is_nominal": 0,
          "discount_nominal": 0,
          "discount_percentage": "10.00",
          "start_date": "2017-01-01",
          "expired_date": "2017-05-01",
          "quantity": 1,
          "created_at": null,
          "updated_at": "2017-03-25 16:45:30"
        },
        "shipment": null,
        "orderdedProducts": [
          {
            "id": 5,
            "order_id": 4,
            "product_id": 1,
            "quantity": 3,
            "total_price": 20697000,
            "created_at": "2017-03-25 16:13:45",
            "updated_at": "2017-03-25 16:13:45",
            "name": "Xiaomi Mi Note 2",
            "detail": "5.7 Inch, Snapdragon 821 quad core CPU, 6GB RAM, 128GB ROM, 22.5MP rear + 8MP front dual camera, Android 6.0 OS.",
            "price": 6899000
          }
        ]
      }
    ]
  }
}

+ Response 500
        {
            "status": 500,
            "message": "Internal Service Error"
        }

### GET [ /orderDetail]
Menampilkan detail order tertentu

+ Parameters
    + orderId - id order

+ Example Request
    `https://frozen-bastion-68983.herokuapp.com/api/orderDetail?orderId=1`

+ Response 200    
{
  "status": 200,
  "message": "Success",
  "data": {
    "order": {
      "id": 1,
      "user_id": 2,
      "coupon_id": 1,
      "shipment_id": 1,
      "is_finalized": 1,
      "name": "customer dyah rahma",
      "phone": "085716661493",
      "email": "dyah.rahma777@gmail.com",
      "address": "Jl Pelesiran 81A/56",
      "original_price": 7200000,
      "final_price": 7150000,
      "payment_proof_path": "/images/payment/1.jpg",
      "is_validated": 1,
      "is_valid": 1,
      "is_shipped": 1,
      "date_order": "2017-03-23 00:00:00",
      "finalizing_time": "2017-03-23 11:00:00",
      "validating_time": "2017-03-23 13:00:00",
      "shipping_time": "2017-03-23 20:33:00",
      "created_at": null,
      "updated_at": null,
      "coupon": {
        "id": 1,
        "code": "PROMO50K",
        "is_nominal": 1,
        "discount_nominal": 50000,
        "discount_percentage": "0.00",
        "start_date": "2017-01-01",
        "expired_date": "2017-05-01",
        "quantity": 15,
        "created_at": null,
        "updated_at": null
      },
      "shipment": {
        "id": 1,
        "no_awb": "01067105501317",
        "shipment_date": "2017-03-23",
        "created_at": null,
        "updated_at": null
      },
      "orderdedProducts": [
        {
          "id": 1,
          "order_id": 1,
          "product_id": 4,
          "quantity": 2,
          "total_price": 3000000,
          "created_at": null,
          "updated_at": null,
          "name": "Xiaomi Redmi 4A",
          "detail": "RAM 2 GB, internal 16 GB, prosesor Snapdragon 425",
          "price": 1500000
        },
        {
          "id": 2,
          "order_id": 1,
          "product_id": 5,
          "quantity": 1,
          "total_price": 4200000,
          "created_at": null,
          "updated_at": null,
          "name": "Xiaomi Mi 5s",
          "detail": "Internal 64 GB, 3 GB RAM, Versi OS Android OS, v6.0 (Marshmallow), Jenis CPU Qualcomm MSM8996 Snapdragon 821 CPU Quad-core, GPU Adreno 530",
          "price": 4200000
        }
      ]
    }
  }
}

+ Response 404
		{
		  "status": 404,
		  "message": "Not Found"
		}

+ Response 500
        {
            "status": 500,
            "message": "Internal Service Error"
        }

### GET [ /cancelOrder]
Membatalkan order karena informasi dianggap tidak valid

+ Parameters
    + orderId - id order

+ Example Request
    `https://frozen-bastion-68983.herokuapp.com/api/cancelOrder?orderId=4`

+ Response 200    
{
  "status": 200,
  "message": "Success"
}

+ Response 404
		{
		  "status": 404,
		  "message": "Not Found"
		}

+ Response 500
        {
            "status": 500,
            "message": "Internal Service Error"
        }

### POST [ /shipOrder]
Memasukkan nomor pengiriman sekaligus otomatis mengubah status order menjadi valid

+ Parameters
    + orderId - id order
    + noAwb - nomor pengiriman(pelacakan)
    + shipmentTime - waktu pengiriman

+ Example Request
    `https://frozen-bastion-68983.herokuapp.com/api/shipOrder
    body:
    {
	  	"orderId": 4,
	  	"noAwb": "55760009883232",
  		"shipmentTime": "2017-03-25 18:15:00"
	}	

+ Response 200    
        {
		  	"status": 200,
		  	"message": "Success"
		}

+ Response 404
        {
		  	"status": 404,
		  	"message": " Not Found."
		}
    
+ Response 500
        {
            "status": 500,
            "message": "Internal Service Error"
        }