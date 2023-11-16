<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendDiscountCode;
use App\Models\Coupon;
use App\Models\CouponHistory;
use Illuminate\Support\Facades\Queue;

class OrderController extends Controller
{
 
    public function checkout()
    {
        $this->getTotalPrice();
        return view('checkout', ['totalPrice' => session('totalPrice')]);
    }



    public function placeOrder(Request $request)
    {
        //check if user is loged in and if are products in cart
        if (Auth::check() && session('cart')) {

            //create or update user's additional information in user_profiles table
            $userProfileValidated = $request->validate([
                'address' => 'required|max:255',
                'address2' => 'nullable',
                'city' => 'required|max:255',
                'postcode' => 'required|max:255',
                'country' => 'required|max:255',
                'mobile' => 'required|max:255',
            ]);

            $user = Auth::user();
            $userProfile = $user->userProfile;

            if ($userProfile) {
                $userProfile->update($userProfileValidated);
            } else {
                $userId = Auth::id();
                $userProfileValidated['user_id'] = $userId;
                $userProfile = UserProfile::create($userProfileValidated);
            }

        
            //save order in db
            $order = OrderDetail::create([
                'user_id' => Auth::id(),
                'total' => session('totalPrice'),
                'payment_id' => '5',
            ]);



            //save ordered products in db
            if (isset($order)) {
                foreach (session('cart') as $item) {
                    $product = Product::where('title', $item['title'])->first();
                    OrderItem::create([
                        'order_id'      =>  $order->id,
                        'product_id'    =>  $product->id,
                        'quantity'      =>  $item['quantity'],
                        'price'         =>  $item['price']
                    ]);
                }

                //save order history in db
                if(session('couponId')){
                    CouponHistory::create([
                        'coupon_id'       => session('couponId'),
                        'order_id'      =>  $order->id,
                        'user_id'       => Auth::id(),
                        'amount'         => session('totalPrice'),
                        'status'        =>  'used',
                    ]);
                }

                //Check if it's the first order of the user, and if so, send discount code.
                $orderCount = OrderDetail::where('user_id', Auth::id())->count();
                if ($orderCount == 1) {
                    // Dispatch the SendDiscountCode job with 15 minutes delay
                    Queue::later(now()->addMinutes(15), new SendDiscountCode(Auth::user()->email, $order->id));
                }
            }

            //remove all products in card session
            session()->forget(['cart']);
            session()->forget(['totalPrice']);

            return redirect()->route('success');
        } else {
            return "Error, Try later";
        }
    }


    public function applyCoupon(Request $request)
    {
        $couponValidated = $request->validate([
            'coupon' => 'required|max:255',
        ]);

        $selectedCoupon = Coupon::where('name', $couponValidated)->first();
        if (isset($selectedCoupon['status']) && $selectedCoupon['status']) {

            session()->put('couponId', $selectedCoupon['id']);
            $totalPrice = $this->getTotalPrice() - $selectedCoupon['discount'];

            session()->put('totalPrice', $totalPrice);

            $response = [
                "totalPrice"        => $totalPrice,
                "discountPrice"     => $selectedCoupon['discount'],
                "discountName"      => $selectedCoupon['name']
            ];

            return $response;
        } else {
            session()->forget(['couponId']);
            $response = [
                "message"   => "Invalid coupon code entered. Please check and try again."
            ];
            return $response;
        }
    }


    public function getTotalPrice()
    {

        $cartItems = session('cart');
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $product = Product::where('title', $item['title'])->first();
            $totalPrice += $product['price'] * $item['quantity'];
        }

        session()->put('totalPrice', $totalPrice);

        return $totalPrice;
    }


    public function success()
    {
        return view('successPage');
    }
}
