<?php

namespace App\Http\Controllers\user;

use Carbon\Carbon;
use App\Models\Card;
use App\Models\Order;
use Nette\Utils\Json;
use App\Models\Product;
use App\Models\OrderList;
use Illuminate\Http\Request;
use PHPUnit\Util\Json as UtilJson;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    // return pizza list
    public function pizzaList(Request $request){

        if($request->status == 'desc'){
            $data = Product::orderBy('created_at','desc')->get();
        } else {
            $data = Product::orderBy('created_at','asc')->get();
        }

        return response()->json($data, 200);
    }

    // return card list
    public function addToCard(Request $request){
        $data = $this->getOrderData($request);
        Card::create($data);

        $response = [
            'message' =>'Add To Card Complete',
            'status' => 'success',
        ];

        return response()->json($response, 200);
    }

    // Order
    public function order(Request $request){
        $total = 0;
        foreach($request->all() as $item){
            $data = OrderList::create([
                'user_id' => $item['user_id'],
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'total' => $item['total'],
                'order_code' => $item['order_code'],
            ]);

            $total += $data->total;
        }

        Card::where('user_id',Auth::user()->id)->delete();

        Order::create([
            'user_id' => Auth::user()->id,
            'order_code' => $data->order_code,
            'total_price' => $total+3000,
        ]);

        return response()->json([
            'status'=> 'true'
        ],200);
    }

    // Clear cart
    public function clearCart(){
        Card::where('user_id',Auth::user()->id)->delete();
    }

    // Clear Current Product
    public function clearCurrentProduct(Request $request){
        Card::where('user_id',Auth::user()->id)
                ->where('product_id',$request->productId)
                ->where('id',$request->orderId)
                ->delete();
    }

    // Increase View Count
    public function increaseViewCount(Request $request){
        $pizza = Product::where('id',$request->productId)->first();

        $viewCount = [
            'view_count' => $pizza->view_count + 1
        ];
        Product::where('id',$request->productId)->update($viewCount);
    }

    // Private Function
    //get order data
    private function getOrderData($request){
        return [
            'user_id' =>$request->userId,
            'product_id' => $request->pizzaId,
            'qty' => $request->count,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }


}
