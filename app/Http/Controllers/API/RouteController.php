<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use PDO;

class RouteController extends Controller
{
    // User List
    public function testing(){
        $user = User::get();
        return response()->json($user, 200);
    }

    // category List
    public function categoryList(){
        $category = Category::orderBy('id','desc')->get();
        return response()->json($category, 200);
    }
    // Products List
    public function productList(){
        $product = Product::get();
        return response()->json($product, 200);
    }

    // create Category
    public function createCategory(Request $request){
        $data = [
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updrate_at' => Carbon::now()
        ];

        $response = Category::create($data);
        return response()->json($response,200);
    }

    public function createContact(Request $request){
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        $response = Contact::create($data);
        return response()->json($data, 200);
    }

    public function deleteCategory(Request $request){
        $data = Category::where('id',$request->category_id)->first();
        if(isset($data)){
            Category::where('id',$request->category_id)->delete();
            return response()->json(['status' => true,'message' => 'Delete Success..'], 200);
        }
        return response()->json(['status' => false,'message' => 'There is no Category...'], 200);
    }

    public function categoryDetails(Request $request){
        $data = Category::where('id',$request->category_id)->first();
        if(isset($data)){
            return response()->json(['category'=> $data], 200);
        }
        return response()->json(['status' => false,'category' => 'There is no Category...'], 404);
    }

    public function categoryUpdate(Request $request){
        $categoryId = $request->id;
        $dbSource = Category::where('id',$request->id)->first();
        if(isset($dbSource)){
            $data = $this->getCategoryData($request);
            Category::where('id',$categoryId)->update($data);
            $response = Category::where('id',$request->id)->first();
            return response()->json(['status'=> true,'message'=>'category update success...','category'=>$response],200);
        }
        return response()->json(['status' => false,'category' => 'There is no Category for Update...'], 404);
    }

    //get category data
    private function getCategoryData($request){
        return [
            'name' => $request->name,
            'updated_at' => Carbon::now()
        ];
    }


}
