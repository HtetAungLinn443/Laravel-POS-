<?php

namespace App\Http\Controllers\user;

use Storage;
use Carbon\Carbon;
use App\Models\Card;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    //user List
    public function userList(){
        $userList = User::where('role','user')->paginate('3');
        return view('admin.userList.list',compact('userList'));
    }

    // User Change Role
    public function userChangeRole(Request $request){
        $updateSource = ['role' => $request->role];

        User::where('id',$request->userId)->update($updateSource);
    }

    // Home Page
    public function homePage(){
        $pizza = Product::orderBy('created_at','desc')->get();
        $category = Category::get();
        $cart = Card::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizza','category','cart','history'));
    }

    // Pizza Filter
    public function filter($categoryId){
        $pizza = Product::where('category_id',$categoryId)->orderBy('created_at','desc')->get();
        $category = Category::get();
        $cart = Card::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizza','category','cart','history'));
    }

    // Products Details Page
    public function detailspage($pizzaId){
        $pizza = Product::where('id',$pizzaId)->first();
        $pizzaList = Product::get();


        return view('user.main.details',compact('pizza','pizzaList'));
    }

    // Cart List
    public function cartList(){
        $cartList = Card::select('cards.*','products.name as pizza_name','products.price as pizza_price','products.image as pizza_image')
                    ->leftJoin('products','products.id','cards.product_id')
                    ->where('cards.user_id',Auth::user()->id)
                    ->get();

        $totalPrice = 0;
        foreach($cartList as $c){
            $totalPrice += $c->pizza_price * $c->qty;
        }


        return view('user.main.cart',compact('cartList','totalPrice'));
    }

    // Change Password page
    public function changePasswordPage(){
        return view('user.password.change');
    }

    // Change password
    public function changePassword(Request $request){
        $this->passwordValidationCheck($request);
        $user = User::select('password')->where('id',Auth::user()->id)->first();
        $dbHashValue = $user->password;

        if(Hash::check($request->oldPassword, $dbHashValue)){
            $data = [
                'password' => Hash::make($request->newPassword)
            ];
            User::where('id',Auth::user()->id)->update($data);
            Auth::logout();
            return redirect()->route('auth#loginPage');
        }
        return back()->with(['notMatch' => 'The Old Password not Match. Try Again!']);
    }

    // Account Change Page
    public function accountChangePage(){
        return view('user.profile.account');
    }

    // Account Change
    public function accountChange($id, Request $request){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);

        if($request->hasFile('image')){
            $dbImage = User::where('id',$id)->first();
            $dbImage = $dbImage->image;

            if($dbImage != null){
                Storage::delete('public/'.$dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$fileName);
            $data['image'] = $fileName;
        }


        User::where('id',$id)->update($data);
        return back()->with(['updateSuccess' => 'Account Updated Success...']);
    }

    // Order History Page
    public function history(){
        $order = Order::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate('8');
        return view('user.main.history',compact('order'));
    }


    // account validation check
    private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email' =>'required',
            'phone' => 'required',
            'image' => 'mimes:png,jpg,jpeg,svg,webp,jfif,pjpeg,pjp|file',
            'gender' => 'required',
            'address' => 'required'
        ],[
            'image.mimes' => 'This file is only can update photo type.'
        ])->validate();
    }

    //request user data
    private function getUserData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'updated_at' => Carbon::now(),
        ];
    }

    // Password Validation Check
    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:6|max:15',
            'newPassword' => 'required|min:6|max:15',
            'confirmPassword' => 'required|min:6|same:newPassword'
        ])->validate();
    }
}
