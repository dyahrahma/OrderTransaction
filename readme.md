This project is available and can be accessed at <a href="https://frozen-bastion-68983.herokuapp.com/api/">https://frozen-bastion-68983.herokuapp.com/api/ </a>

---------------------------------------------
# Daftar API yang tersedia

## POST [ /authentication]
Melakukan login untuk memperoleh token yang akan digunakan dalam mengakses API selanjutnya

+ Parameters
    ++ email - email pengguna
    ++ password - password pengguna

+ Example Request
    ++ Login Customer
   		`https://frozen-bastion-68983.herokuapp.com/api/authenticate`
   		body:
   		{
			"email": "dyah.rahma777@gmail.com",
			"password": "dyah123"
   		}

    ++ Login Admin
   		`https://frozen-bastion-68983.herokuapp.com/api/authenticate`
   		body:
   		{
			"email": "dyah.rahma777@gmail.com",
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
Untuk dapat menggunakan API di bawah ini, token yang didapat dari proses login harus ditambahkan pada header request.
Pada header tambahkan:
Authorization -> Bearer "token_yang_diperoleh"
contoh:
Authorization -> Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hcGlcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTQ5MDQ0MjE0MiwiZXhwIjoxNDkxMDQ2OTQyLCJuYmYiOjE0OTA0NDIxNDIsImp0aSI6IjJhYmZmN2VlNjdmMThlMjgxMTk1YWE2ZjQwY2ZmZDM0In0.mPAAF22hsTv4opH9vqmKzz_CcpjjiUeepor-ZUwXzJs
---------------------------------------------

## API untuk Customer -> hanya bisa diakses menggunakan token hasil login sebagai customer

### GET [ /addProduct]
Melakukan penambahan produk pada order

+ Parameters
    ++ productId - id produk yg akan ditambahkan
    ++ quantity - banyaknya produk yg akan ditambahkan

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
    ++ orderId - id order yg ingin diberi kupon
    ++ coupon - kode kupon yang ingin ditambahkan

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
    ++ orderId - id order yg ingin diberi kupon
    ++ useRegisteredData (true/false) - true jika menggunakan data yang tersimpan, false jika ingin memasukkan data baru
    ++ name, phone, email, address jika useRegisteredData == true

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
    ++ orderId - id order yang akan dicek

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
			"message": "order id not found"
		}
    
+ Response 500
        {
            "status": 500,
            "message": "Internal Service Error"
        }

### GET [ /checkShipmentStatus]
Melakukan pengecekan status pengiriman

+ Parameters
    ++ shippingId - nomor pengiriman

+ Example Request
    `https://frozen-bastion-68983.herokuapp.com/api/checkShipmentStatus?shippingId=01067105501317`