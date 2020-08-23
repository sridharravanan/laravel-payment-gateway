<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Payments;
use App\Models\Post;

use App\Models\SubCategory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Helpers\Pagination;
use Illuminate\Support\Facades\DB;;
use Razorpay\Api\Api;
class DashboardController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard.index',["user_data"=>Auth::user(),"razorpay_key"=>Config::get('constants.razorpay.key')]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getGrid(Request $request){
        $query = Post::query()->select('post.*','sub_category.name as sub_category_name','category.name as category_name','payments.payment_id')
            ->leftJoin('sub_category', 'sub_category.id', '=', 'post.sub_category_id')
            ->leftJoin('category', 'category.id', '=', 'sub_category.category_id')
            ->leftJoin('payments', function($join) {
                $join->on('payments.post_id', '=', 'post.id');
                $join->where('payments.user_id', '=', Auth::id());

            })

        ;
        $query->with(['frontImage','postPdf','tutor']);
        return Pagination::preparePagination($query,$request,['post.name','sub_category.name','category.name']);
    }
    /**
     * create a payment
     *
     * @return \Illuminate\Http\Response
     */
    public function paySuccess(Request $request){
        $request->validate([
            'post_id'  => 'required|numeric',
            'payment_id'  => 'required|unique:payments,payment_id',
            'amount'  => 'required|numeric|gt:0|regex:/^\d+(\.\d{1,2})?$/',
        ]);
        $message = DB::transaction(function() use ($request) {
            $data = $request->all();
            $data['user_id'] = Auth::id();
            $data['purchase_date'] = date('Y-m-d');
            //#todo payment routing...!
            $payment = Payments::create($data);
            if( $payment ){
                $post = Post::findOrFail($payment['post_id']);
                $post->tutor;
                $post->postTutors;
                //#share tutor + one owner
                $totalAuthor = count($post['postTutors']) + 1;
                $amountInPaise = (int)($post['amount'] * 100);
                $sharedAmountInPaise = (int)( $amountInPaise / $totalAuthor );
                //#onwer for the post
                $routingArray[] = [
                    'account' => $post['tutor']['razorpay_id'],
                    'amount' => $sharedAmountInPaise,
                    'currency' => 'INR'
                ];
                //#shared owner's for the post
                if( count($post['postTutors']) > 0 ){
                    foreach ( $post['postTutors'] as $key => $item ){
                        $routingArray[] = [
                            'account' => $item['tutor']['razorpay_id'],
                            'amount' => $sharedAmountInPaise,
                            'currency' => 'INR'
                        ];
                    }
                }
                $this->capturePayment($payment['payment_id'],$amountInPaise,$routingArray);


            }
        });
        return response()->json($message, 200);
    }
    /**
     * after payment it will redirect to successful page..!
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postDownload(Request $request,$paymentID){
        $payment = Payments::where("payment_id",$paymentID)->with(['post'])->first();
        if( !is_null($payment) ){
            $payment['post']['postPdf']['uploaded_path'] = "/".str_replace('public','storage',$payment['post']['postPdf']['uploaded_path']);
            return view('dashboard.payment_success',['payment'=>$payment]);
        }
        return  abort(404);
    }
    /**
     * for additional data used for dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function getAdditionalData(Request $request){
        return response()->json([
            "category"  => Category::with('subCategory')->get(),
            "sub_category"  => SubCategory::get(),
            "student" => User::getUserCountBasedOnRole(Config::get('constants.role.slug_student.slug')),
            "tutor" => User::getUserCountBasedOnRole(Config::get('constants.role.slug_tutor.slug')),
            "post" => Post::count(),
        ], 200);
    }
   /**
    * @param $payment_id string
    * @param $amount float
    * @param $routingAccount array and it contain account,amount,currency
    *
    */
    public function capturePayment($payment_id,$amount,$routingAccount = array()){
        $razorpayApi = new Api(Config::get('constants.razorpay.key'), Config::get('constants.razorpay.secret'));
        $capture = $razorpayApi->payment->fetch($payment_id)->capture(array('amount'=>$amount, 'currency'=>"INR"));
        if( $capture ){
            if( count($routingAccount) > 0 ){
                $razorpayApi->payment->fetch($payment_id)->transfer(array('transfers' => $routingAccount));
            }
        }
    }
}
