<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Exception;

class DataBase extends Controller
{

    public $status=0;
    function registration(Request $req){
        try {
            $newUser = new User;
            $newUser->name = $req->name;
            $newUser->email = $req->email;
            $newUser->password = $req->password;
            $newUser->status=0;
            $newUser->save();
            

            Schema::create($req->name.'_orders', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->integer('price');
                $table->integer('qty');
                $table->string('image1');
            });

            return redirect()->back()->with('success', "You are successfully Registered");

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    function login(Request $req){
        try {
            $req->validate([
                'email'=> 'required',
                'password'=>'required'  
              ]);
              $check=0;
              $email = $req->email;
              $password = $req->password;
              if ($email=="admin@admin.com" && $password = "admin@123") {
                  return redirect('/admin');
              } else {
                  $data = DB::table('users')->where('email', $email)->where('password', $password)->get();
                  DB::update("UPDATE `users` SET `status`= 1 WHERE `email` = '".$req->email."'");
                  $check = count($data);
                  if($check!=0){
                      return redirect('/user/'.$email);
                  }
                  else{
                      return redirect()->back()->with('error', 'Sorry, your email or password was incorrect. Please double-check your credentials.');
                  }   
              }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    function addnewproduct(Request $req)
    {
        try {
            $servicepicture = null;
            if ($req->hasFile('image')) {
                $image = $req->file('image');
                $image_name = $image->getClientOriginalName();
                $image->move(public_path('/imgs/services'), $image_name);
                $servicepicture = "imgs/services/" . $image_name;
            }
    
            DB::table('products')->insert([
                'name' => $req->name,
                'description' => $req->description,
                'price' => $req->price,
                'qty' => 1,
                'image1' => $servicepicture,
                'image2' => $servicepicture
            ]);
    
            return redirect()->back()->with('success', "Service is successfully added");
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    

    function checkStatus($email){
        $data = DB::select("select * from `users` where `email` = '".$email."'");
        foreach($data as $user){
            $this->status=$user->status;
        }
    }

    function carousel($email){
        $this->checkStatus($email);
        $sliders = Product::all();
        return view('welcome')->with('sliders', $sliders)->with('email', $email)->with('status', $this->status);
    }
    function showproduct($email, $servicename){
        $this->checkStatus($email);
        $sliders = DB::select("select * from `products` where `name` = '".$servicename."'");
        // dd($sliders);
        $secondslide = Product::all();
        return view('product')->with('sliders', $sliders)->with('second', $secondslide)->with('email', $email)->with('status', $this->status);
    }
    
    function showshop($email){
        $this->checkStatus($email);
        $data = Product::all();
        return view('shop')->with('collection', $data)->with('email', $email)->with('status', $this->status);
    }
    function logout($email){
        DB::update("UPDATE `users` SET `status`= 0 WHERE `email` = '".$email."'");
        return redirect('/');
    }

    function addtocart(Request $req, $email, $name, $price, $image){
        $check=0;
        $qty=0;
        $quantity=0;
        $user = DB::select("select * from `users` where `email` = '".$email."'");
        foreach($user as $item){
            $username=$item->name;
        }
        $products = DB::select("select * from `products` where `name` = '".$name."'");
        foreach($products as $product){
            $quantity = $product->qty;
        }
        if($quantity==0){
            return redirect()->back()->with('empty', 'Out Of Service');
        }
        else{
            $checkProduct = DB::select("select * from `".$username."_orders`");
            foreach($checkProduct as $product){
                if($product->name==$name){
                    $check=1;
                    $qty=$qty+$product->qty;
                    break;
                }
            }
            if($check==1){
                $req->qty = 1;
                DB::update("UPDATE `".$username."_orders` SET `qty`= ".$qty." WHERE `name` = '".$name."'");
            }
            else{
                $req->qty = 1;
                DB::insert("INSERT INTO `".$username."_orders`(`id`, `name`, `price`, `qty` , `image1`) VALUES (NULL,'".$name."','".$price."','".$req->qty."', 'imgs/services/".$image."')");    
            }
            return redirect()->back()->with('success', 'Successfully Added');
        }
    }

    function showcart($email){
        $name='';
        $user = DB::select("select * from `users` where `email` = '".$email."'");
        foreach($user as $item){
            $name=$item->name;
        }
        $data = DB::select("select * from `".$name."_orders`");
        return view('cart', ['orders'=>$data])->with('email', $email);
    }

    function deletefromcart($email, $name){
        $user = DB::select("select * from `users` where `email` = '".$email."'");
        foreach($user as $item){
            $username=$item->name;
        }
        DB::delete("DELETE FROM `".$username."_orders` WHERE `name` = '".$name."'");
        return redirect()->back();
    }
    function checkout($email, $total)
    {
        $user = DB::select("SELECT * FROM `users` WHERE `email` = '".$email."'");
        foreach ($user as $item) {
            $username = $item->name;
        }

        $orders = DB::select("SELECT * FROM `".$username."_orders`");

        $message = "Username: ".$username."\n";
        $message .= "Email: ".$email."\n";
        $message .= "Total: ".$total." $\n";

        // Add the order details to the email body
        $message .= "Order Details:\n";
        foreach ($orders as $order) {
            $message .= "Service: ".$order->name."\n";
        }

        // Send the email
        Mail::raw($message, function ($emailMessage) use ($email, $username) {
            $emailMessage->to('farhadnazir29@gmail.com')
                ->subject('New Order Received')
                ->from($email);
        });

        foreach ($orders as $order) {
            $products = DB::select("SELECT * FROM `products` WHERE `name` = '".$order->name."'");
            foreach ($products as $product) {
                $quantity = $product->qty;
            }
            $quantity = $quantity - $order->qty;
            DB::update("UPDATE `products` SET `qty` = ".$quantity." WHERE `name` = '".$order->name."'");
        }

        DB::delete("DELETE FROM `".$username."_orders`");
        return redirect('/user/'.$email);
    }

    
    function showlist(){
        $products = DB::select("select * from `products`");
        return view ('adminlist', ['collection'=>$products]);
    }

    function showupdatepage($name){
        $products = DB::select("select * from `products` where `name` = '".$name."'");
        return view('updateproduct', ['collection'=>$products]);
    }

    function updateproduct(Request $req, $name){
        $products = DB::select("select * from `products` where `name` = '".$name."'");
        DB::table('products')->where('name', $name)->update([
        'name' => $req->name,
        'description' => $req->description,
        'price' => $req->price,
        'qty' => 1
        ]);
        // DB::update("UPDATE `products` SET `name`='".$req->name."',`description`='".$req->description."',`price`= ".$req->price.",`qty`= ".$req->quantity." WHERE `name` = '".$name."'");
        return redirect('/list');
    }

    function deleteproduct($name){
        DB::delete("DELETE FROM `products` WHERE `name` = '".$name."'");
        return redirect()->back();
    }
}