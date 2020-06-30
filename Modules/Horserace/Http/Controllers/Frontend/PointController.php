<?php

namespace Modules\Horserace\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Modules\Horserace\Repositories\JWTRepositories;
use Session, Auth;
use Modules\Horserace\Repositories\PointRepositories;
use Modules\Horserace\Repositories\TransactionDepositRepositories;

class PointController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:web');
    $this->middleware('user_activity');
  }

  public function pointChargeTopConfirm(Request $request,
                                        PointRepositories $pointRepositories)
  {
    $input = $request->all();
    $data['point_detail'] = $pointRepositories->getEditPoint(trim($input["id"]));
    return view('horserace::frontend.point.charge_top_confirm', compact('data'));
  }

  public function getPointChargeTopBank(Request $request,
                                        PointRepositories $pointRepositories,
                                        JWTRepositories $JWTRepositories,
                                        TransactionDepositRepositories $transactionDepositRepositories)
  {
    $input = $request->all();
    $input['user_id'] = Auth::user()->id;
    $input['login_id'] = Auth::user()->login_id;
    $input['member_level'] = Auth::user()->member_level;
    $input['amount'] = trim($input["price"]);
    // Save template data
    $trans_id = $transactionDepositRepositories->transDepositStoreGetId($input);

    // Info show
    $data['point'] = trim($input["point"]);
    $data['price'] = trim($input["price"]);
    $data['method'] = trim($input["method"]);
    $data['user_id'] = Auth::user()->id;
    $data['mail_pc'] = Auth::user()->mail_pc;
    $data['login_id'] = Auth::user()->login_id;
    $data['trans_id'] = $trans_id;

    // JWT
    $data_jwt = [
      'trans_id' => $trans_id,
      'point' => trim($input["point"]),
      'price' => trim($input["price"]),
      'method' => trim($input["method"]),
      'option' => NOT_SAVE_INFO_DEPOSIT,
      'user_id' => Auth::user()->id,
    ];
    $data["checksum"] = $JWTRepositories->createJWTBank($data_jwt);

    // if(isset($input['comfirm']))
    // {
    //   $trans_id = $transactionDepositRepositories->transDepositStoreGetId($input);
    //   $data_jwt = [
    //     'trans_id' => $trans_id,
    //     'point' => trim($input["point"]),
    //     'price' => trim($input["price"]),
    //     'method' => trim($input["method"]),
    //     'option' => NOT_SAVE_INFO_DEPOSIT,
    //     'user_id' => Auth::user()->id,
    //   ];
    //   $data['checksum'] = $JWTRepositories->createJWTBank($data_jwt);
    //   // log data chuyen cho ngân hàng
    //   request_api_log("------Log data bank request payment form   ---: /n ".print_r($input, true));
    //   return view('horserace::frontend.point.charge_top_bank', compact('data'));
      
    // }
    // request_api_log("------Log data bank request payment form   ---: /n ".print_r($data, true));
    return view('horserace::frontend.point.charge_top_bank', compact('data'));
  }

  public function getPointChargeTopCredit(Request $request,
                                          PointRepositories $pointRepositories,
                                          JWTRepositories $JWTRepositories,
                                          TransactionDepositRepositories $transactionDepositRepositories)
  {
    $input = $request->all();
    // request_api_log("------Log input credit request payment form   ---: /n ".print_r($input, true));
    $input['user_id'] = Auth::user()->id;
    $input['login_id'] = Auth::user()->login_id;
    $input['member_level'] = Auth::user()->member_level;
    $input['amount'] = trim($input["price"]);
    // Save template data
   $trans_id = $transactionDepositRepositories->transDepositStoreGetId($input);

    // Show info
    $data['point'] = trim($input["point"]);
    $data['price'] = trim($input["price"]);
    $data['method'] = trim($input["method"]);
    $data['user_id'] = Auth::user()->id;
    $data['mail_pc'] = Auth::user()->mail_pc;
    $data['login_id'] = Auth::user()->login_id;
    $data['trans_id'] = $trans_id;

    // JWT
    $data_jwt = [
      'trans_id' => $trans_id,
      'point' => trim($input["point"]),
      'price' => trim($input["price"]),
      'method' => trim($input["method"]),
      'option' => NOT_SAVE_INFO_DEPOSIT,
      'user_id' => Auth::user()->id,
    ];
    $data["checksum"] = $JWTRepositories->createJWT($data_jwt);
    // if(isset($input['comfirm']))
    // {
    //   $trans_id = $transactionDepositRepositories->transDepositStoreGetId($input);
    //   $data_jwt = [
    //     'trans_id' => $trans_id,
    //     'point' => trim($input["point"]),
    //     'price' => trim($input["price"]),
    //     'method' => trim($input["method"]),
    //     'option' => NOT_SAVE_INFO_DEPOSIT,
    //     'user_id' => Auth::user()->id,
    //   ];
    //   $data['trans_id'] = $trans_id;
    //   $data['checksum'] = $JWTRepositories->createJWTBank($data_jwt);
    //   request_api_log("------Log data credit request payment form   ---: /n ".print_r($data, true));
    //   return view('horserace::frontend.point.charge_top_credit', compact('data'));
      
    // }
    // request_api_log("------Log data credit request payment form   ---: /n ".print_r($data, true));
    return view('horserace::frontend.point.charge_top_credit', compact('data'));
  }

  public function getPointChargeTopBankComp(Request $request,
                                            TransactionDepositRepositories $transactionDepositRepositories)
  {
    $input = $request->all();
    $input['user_id'] = Auth::user()->id;
    $input['login_id'] = Auth::user()->login_id;
    $input['member_level'] = Auth::user()->member_level;
    $input['amount'] = trim($input["price"]);
    $data = $input;
    // Save transaction
    $result = $transactionDepositRepositories->transactionDepositStore($input);
    // request_api_log("------Log data bank complete request payment form   ---: /n ".print_r($data, true));
    return view('horserace::frontend.point.charge_top_bank_comp', compact("data"));
  }

  public function getPointChargeTopCreditComp(Request $request,
                                              TransactionDepositRepositories $transactionDepositRepositories)
  {
    $input = $request->all();
    $input['user_id'] = Auth::user()->id;
    $input['login_id'] = Auth::user()->login_id;
    $input['member_level'] = Auth::user()->member_level;
    $input['amount'] = trim($input["price"]);
    $data = $input;
    // Save transaction
    $result = $transactionDepositRepositories->transactionDepositStore($input);
    // request_api_log("------Log data credit complete request payment form   ---: /n ".print_r($data, true));
    return view('horserace::frontend.point.charge_top_credit_comp', compact('data'));
  }

}
