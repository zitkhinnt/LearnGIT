<?php

namespace Modules\Horserace\Http\Controllers\API;

use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Horserace\Entities\TransactionDeposit;
use Modules\Horserace\Repositories\JWTRepositories;
use Modules\Horserace\Repositories\TransactionDepositRepositories;
use Modules\Horserace\Repositories\UserActivityRepositories;
use Modules\Horserace\Repositories\PointRepositories;
use Exception;

class APIController extends Controller
{

  public function depositResult(Request $request,
                                JWTRepositories $JWTRepositories,
                                TransactionDepositRepositories $transactionDepositRepositories,
                                PointRepositories $point_repository)
  {
    // Log
    $time = date('Y-m-d H:i:s a');
    $log['time'] = 'time test v2: ' . $time;

    // Input
    $input = $request->all();
    $check_validation = false;
    //$check_validation = true;

    // log
    $log['request'] = $input;
    api_log(print_r($log, true));
    // Check bank or checksum.
    if (isset($input["banktransfer"]) || isset($input["checksum"])) {
      $check_validation = true;
      $log['validation_request'] = [
        "banktransfer" => isset($input["banktransfer"]) ? "yes" : "no",
        "checksum" => isset($input["checksum"]) ? "yes" : "no",
      ];
    }

    // Check ip
    $ip = $_SERVER['REMOTE_ADDR'];
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    // List ip apply
    $arr_ip[] = "54.65.177.67";
    $arr_ip[] = "54.238.8.174";
    $arr_ip[] = "54.95.89.20";

    // IP test
    $arr_ip[] = "14.165.42.210";
    $arr_ip[] = "127.0.0.1";

    if (in_array($ip, $arr_ip)) {
      $check_validation = true;
    } else {
      // Check IP address band
      $ipstart = '52.196.8.0';
      $ipend = '52.196.8.255';

      if (ipbetweenrange($ip, $ipstart, $ipend)) {
        $check_validation = true;
      }
    }

    // Log ip
    $log['ip'] = $ip;

    // Check sum && Check status success
    if ($check_validation) {
      if (isset($input["banktransfer"])) {
        // Bank
        $token = $input["option"];
        $respond_status = $input["status"];
      } else {
        // Credit
        $token = $input["checksum"];

        // dat fix credit card allway yes
        if($input['rel'] == 'yes')
          $respond_status = "OK";
        else
          $respond_status = "FAIL";
      }

      // Update
      // $check_jwt = $JWTRepositories->checkJWT($token);
      $check_jwt = [];
      $token_arr = explode (".", $token);
      $check_jwt['content'] = (array) json_decode(base64_decode($token_arr[1]));
      $check_jwt['status'] = "SUCCESS";

      if ($check_jwt["status"] == "SUCCESS") {
        $result = "SuccessOK";

        // Information
        $trans_id = $check_jwt["content"]["data"]->trans_id;
        $point = $check_jwt["content"]["data"]->point;
        $amount = $check_jwt["content"]["data"]->price;
        $payment_date = \Carbon\Carbon::now()->toDateTimeString();//get date system
        // Update status
        $obj_transaction_deposit = new TransactionDeposit();
        $trans = $obj_transaction_deposit->getTransactionDepositById($trans_id);
        // Not apply

        if ($trans->status == NOT_APPLY) {
          if ($respond_status != "FAIL" || $respond_status == "TEST") {
            // Respond success
            if($input['money']==$amount){
                $arr_trans_deposit = [
                "status" => APPLY,
                "result" => json_encode($input),
                "note" => $respond_status,
                "point" => $check_jwt["content"]["data"]->point,
                "amount_pay" => $input['money'],
                "payment_at" => $payment_date,
              ];
              $obj_transaction_deposit->updateTransactionDeposit($trans_id, $arr_trans_deposit);

              // Add point deposit
              $obj_user_activity_repositories = new UserActivityRepositories();
              $obj_user_activity_repositories->depositPoint($trans->user_id, $point, $amount);

              // Log
              $log['trans'] = [
                "status" => "add success",
                "trans_id" => $trans->id,
                "user_id" => $trans->user_id,
                "login_id" => $trans->login_id,
                "point" => $check_jwt["content"]["data"]->point,
                "amount_pay" => $input['money'],
                "payment_at" => $payment_date,
              ];
            }else{
              // amount & pont dont have system
              if($input['money'] > $amount){
                $respond_status = "OVER";
              }else{
                $respond_status = "LESS";
              }
              $point_in = floor($input['money']/100);
              $arr_trans_deposit = [
                "status" => APPLY,
                "result" => json_encode($input),
                "note" => $respond_status,
                "point" => $point_in,
                "amount_pay" => $input['money'],
                "payment_at" => $payment_date,
              ];
              $obj_transaction_deposit->updateTransactionDeposit($trans_id, $arr_trans_deposit);

              // Add point deposit
              $obj_user_activity_repositories = new UserActivityRepositories();
              $obj_user_activity_repositories->depositPoint($trans->user_id, $point_in, $input['money']);

              // Log
              $log['trans'] = [
                "status" => "add success",
                "trans_id" => $trans->id,
                "user_id" => $trans->user_id,
                "login_id" => $trans->login_id,
                "note" => $respond_status,
                "point" => $point_in,
                "amount_pay" => $input['money'],
                "payment_at" => $payment_date,
              ];
            }
          } else {
            // Respond fail
            $arr_trans_deposit = [
              "result" => json_encode($input),
              "note" => $respond_status,
            ];
            $obj_transaction_deposit->updateTransactionDeposit($trans_id, $arr_trans_deposit);

          }
        } else {
            $point_in = floor($input['money']/100);
            $check_method = $trans->method;
            // get point package lan 2
            if ($respond_status == "OK") {
              if($check_method == "1"){
                $input_new = [
                  "user_id" => $trans->user_id,
                  "login_id" => $trans->login_id,
                  'method' => $trans->method,
                  'member_level' => $trans->member_level,
                  "point" => $point_in,
                  "amount" => $input['money'],
                  "amount_pay" => $input['money'],
                  "status" => APPLY,
                  "result" => json_encode($input),
                  "note" => $respond_status,
                  "first_trans_id" => $trans_id,
                  "payment_at" => $payment_date,
                ];
                $trans_id_new = $obj_transaction_deposit->insertTransactionDepositGetId($input_new);
  
                // Add point deposit
                $obj_user_activity_repositories = new UserActivityRepositories();
                $obj_user_activity_repositories->depositPoint($trans->user_id, $point_in, $input['money']);
                // Log
                $log['trans'] = [
                  "status" => "add success",
                  "trans_id" => $trans_id_new,
                  "user_id" => $trans->user_id,
                  "login_id" => $trans->login_id,
                  "point" => $point_in,
                  "amount" => $input['money'],
                  "amount_pay" => $input['money'],
                  "first_trans_id" => $trans_id,
                  "payment_at" => $payment_date,
                ];
              } else {
                $input_new = [
                  "user_id" => $trans->user_id,
                  "login_id" => $trans->login_id,
                  'method' => $trans->method,
                  'member_level' => $trans->member_level,
                  "point" => $point_in,
                  "amount_pay" => $input['money'],
                  "status" => APPLY,
                  "result" => json_encode($input),
                  "note" => $respond_status,
                  "first_trans_id" => $trans_id,
                  "payment_at" => $payment_date,
                ];
                $trans_id_new = $obj_transaction_deposit->insertTransactionDepositGetId($input_new);
  
                // Add point deposit
                $obj_user_activity_repositories = new UserActivityRepositories();
                $obj_user_activity_repositories->depositPoint($trans->user_id, $point_in, $input['money']);
                // Log
                $log['trans'] = [
                  "status" => "add success",
                  "trans_id" => $trans_id_new,
                  "user_id" => $trans->user_id,
                  "login_id" => $trans->login_id,
                  "point" => $point_in,
                  "amount_pay" => $input['money'],
                  "first_trans_id" => $trans_id,
                  "payment_at" => $payment_date,
                ];
              }
            } elseif ($respond_status == "TIMEOUT") {
              $input_new = [
                "user_id" => $trans->user_id,
                "login_id" => $trans->login_id,
                'method' => $trans->method,
                'member_level' => $trans->member_level,
                "point" => $point_in,
                "amount_pay" => $input['money'],
                "status" => APPLY,
                "result" => json_encode($input),
                "note" => "OK",
                "first_trans_id" => $trans_id,
                "payment_at" => $payment_date,
              ];
              $input_update = [
                "note" => $respond_status,
              ];
              //update id nào bị timeout, nhưng ko cộng point vào tk
              $obj_transaction_deposit->updateTransactionDeposit($trans_id, $input_update);

              //insert id mới với số tiền mà ngân hàng đã trả
              $trans_id_new = $obj_transaction_deposit->insertTransactionDepositGetId($input_new);
              // Add point deposit
              $obj_user_activity_repositories = new UserActivityRepositories();
              $obj_user_activity_repositories->depositPoint($trans->user_id, $point_in, $input['money']);
              // Log
              $log['trans'] = [
                "status" => "add success",
                "trans_id" => $trans_id_new,
                "user_id" => $trans->user_id,
                "login_id" => $trans->login_id,
                "point" => $point_in,
                "amount_pay" => $input['money'],
                "first_trans_id" => $trans_id,
                "payment_at" => $payment_date,
              ];
            } else {
              
              $input_new = [
                "user_id" => $trans->user_id,
                "login_id" => $trans->login_id,
                'method' => $trans->method,
                'member_level' => $trans->member_level,
                "point" => $point_in,
                "amount_pay" => $input['money'],
                "status" => NOT_APPLY,
                "result" => json_encode($input),
                "note" => $respond_status,
                "first_trans_id" => $trans_id,
                "payment_at" => $payment_date,
              ];
              $trans_id_new = $obj_transaction_deposit->insertTransactionDepositGetId($input_new);
              // Log
              $log['trans'] = [
                "status" => "add success",
                "trans_id" => $trans_id_new,
                "user_id" => $trans->user_id,
                "login_id" => $trans->login_id,
                "point" => $point_in,
                "amount_pay" => $input['money'],
                "first_trans_id" => $trans_id,
                "payment_at" => $payment_date,
              ];
            }
        }
      } else {
        $log['message'] = $check_jwt;
        $result = "Error";
      }
    } else {
      $log['message'] = "Validation IP";
      $result = "Error";
    }

    $log['result'] = $result;
    api_log(print_r($log, true));
    return $result;
  }

  public function test(Request $request)
  {
    echo "test";
  }

  public function isUserRegisterAfter24h(Request $request)
  {
    // Input API controller
    $input = $request->all();
    if (isset($input['mail_pc']) && !is_null($input['mail_pc']) && (strlen($input['mail_pc']) > 0) && $_SERVER['HTTP_AUTHORIZATION'] == 'wido1234!#' ){
      $result = DB::table('users')
      ->where('mail_pc', 'LIKE', $input['mail_pc']);
      
      if ($result->first()){
        $result = $result->whereRaw('register_time <= NOW() - INTERVAL 1 DAY')->first();

        if (!$result)
          return response()->json(['status' => 'not_24h'], 200);
        else
          return response()->json(['status' => 'ok_24h'], 201);
      }
      else
        return response()->json(['status' => 'Not Found'], 404);
    }
    else 
      return response()->json(['status' => 'Forbidden'], 403);
  }
}
