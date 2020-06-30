<?php

namespace Modules\Horserace\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Horserace\Entities\TransactionDeposit;
use Modules\Horserace\Repositories\TransactionDepositRepositories;
use Modules\Horserace\Repositories\TransactionGiftRepositories;
use Modules\Horserace\Repositories\TransactionPaymentRepositories;
use Modules\Horserace\Entities\User;

class PaymentController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:admin');
    $this->middleware('admin');
  }

  public function payment(Request $request,
                          TransactionPaymentRepositories $transactionPaymentRepositories)
  {
    $data["trans_payment"] = $transactionPaymentRepositories->getListTransactionPayment();
    return view('horserace::backend.payment.payment', compact("data"));
  }

  public function paymentAjax(Request $request, TransactionPaymentRepositories $transactionPaymentRepositories)
  {
    $input = $request->all();
    $result = $transactionPaymentRepositories->getListTransactionPaymentAjax($input);
    $data = [
      "draw" => 0,
      "recordsTotal" => $result['total'],
      "recordsFiltered" => $result['total'],
    ];
    $data['data'] = array();
    foreach ($result['result'] as $item) {

      $data['data'][] = [
        $item->id,
        $item->created_at,
        '<a href="' . route("admin.user.edit", $item->user_id) . '">' . $item->login_id . '</a>',
        number_format($item->point) . " pt",
        $item->prediction_name
      ];
    }
    return response()->json($data);
  }

  public function deposit(Request $request,
                          TransactionDepositRepositories $transactionDepositRepositories)
  {
    $data["trans_deposit"] = $transactionDepositRepositories->getListTransactionDeposit();
    return view('horserace::backend.payment.deposit', compact("data"));
  }

  public function depositAjax(Request $request, TransactionDepositRepositories $transactionDepositRepositories)
  {
    $input = $request->all();
    $result = $transactionDepositRepositories->getListTransactionDepositAjax($input);
    $data = [
      "draw" => 0,
      "recordsTotal" => $result['total'],
      "recordsFiltered" => $result['total'],
    ];
    $data['data'] = array();
    foreach ($result['result'] as $item) {
      if (isset($item->first_trans_id)) {
        if ($item->first_trans_id != NULL) {
          $created = '';
          $note = 'スピ';
        }
      } else {
        $created = $item->created_at;
        $note = transferStatusToStr('horserace', $item->note);
      }
      $class = depositToClass($item);
      $data['data'][] = [
        [
          'id' => $item->id,
          'user_id' => $item->user_id,
          'login_id' => $item->login_id,
          'point' => $item->point,
          'amount' => $item->amount,
          'method' => $item->method,
        ],
        $item->id,
        $created,
        $item->payment_at,
        '<a href="' . route("admin.user.edit", $item->user_id) . '">' . $item->login_id . '</a>',
        number_format($item->point),
        "¥ " .  number_format($item->amount),
        "¥ " .  number_format($item->amount_pay),
        methodDepositStr('horserace', $item->method),
        paymentStatusStr('horserace', $item->status),
        memberLevelStr('horserace', $item->member_level),
        $note,
        [
          'class' => $class
        ],
      ];
    }
    return response()->json($data);
  }

  public function applyDeposit(Request $request,
                               TransactionDepositRepositories $transactionDepositRepositories)
  {
    $input = $request->all();
    $result = $transactionDepositRepositories->changeStatusTransDeposit($input);
    return redirect()->route('admin.deposit')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }
//New Add Deposit Manual
  public function addDeposit(Request $request,
                               TransactionDepositRepositories $transactionDepositRepositories)
  {
    $input = $request->all();
    $obj_user = new User();
    $user_deposit = $obj_user->getUserByLoginId($input['login_id']);   
    if(!isset($user_deposit))
      return redirect()->route('admin.deposit');
    $input['member_level'] = $user_deposit->member_level;
    $input['user_id'] = $user_deposit->id;
    $result = $transactionDepositRepositories->transactionDepositStore($input);
    return redirect()->route('admin.deposit')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  
  }

  public function gift(Request $request,
                       TransactionGiftRepositories $transactionGiftRepositories)
  {
    $data["trans_gift"] = $transactionGiftRepositories->getTransactionGift();
    return view('horserace::backend.payment.gift', compact("data"));
  }

  public function giftAjax(Request $request, TransactionGiftRepositories $transactionGiftRepositories)
  {
    $input = $request->all();
    $result = $transactionGiftRepositories->getTransactionGiftAjax($input);
    $data = [
      "draw" => 0,
      "recordsTotal" => $result['total'],
      "recordsFiltered" => $result['total'],
    ];
    $data['data'] = array();
    foreach ($result['result'] as $item) {

      $data['data'][] = [
        $item->id,
        $item->created_at,
        '<a href="' . route("admin.user.edit", $item->user_id) . '">' . $item->login_id . '</a>',
        memberLevelStr('horserace', $item->member_level),
        number_format($item->point) . " pt",
        '<span style="font-weight: bold;">' . $item->gift_name . '</span>'
      ];
    }
    return response()->json($data);
  }


  public function addGiftBonus(Request $request,
                               TransactionGiftRepositories $transactionGiftRepositories)
  {
    $input = $request->all();
    $result = $transactionGiftRepositories->addGiftBonus($input);
    return redirect()->route('admin.trans_gift')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  public function addGiftAll(Request $request,
                             TransactionGiftRepositories $transactionGiftRepositories)
  {
    $input = $request->all();
    $result = $transactionGiftRepositories->addGiftAll($input);
    return redirect()->route('admin.user.search')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }

  public function removeGiftAll(Request $request,
                                TransactionGiftRepositories $transactionGiftRepositories)
  {
    $input = $request->all();
    $result = $transactionGiftRepositories->removeGiftAll($input);
    return redirect()->route('admin.user.search')->with([
      'flash_level' => $result["status"],
      'flash_message' => $result["message"],
    ]);
  }
}
