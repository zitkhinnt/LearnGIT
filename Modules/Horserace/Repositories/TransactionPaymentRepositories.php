<?php

namespace Modules\Horserace\Repositories;

use DB;
use DateTime;
use hasFile;
use Modules\Horserace\Entities\TransactionPayment;

class TransactionPaymentRepositories
{
  public function transactionPaymentStore($input)
  {
    $obj_transaction_payment = new TransactionPayment();
    $arr_transaction_payment = [
      'user_id' => trim($input['user_id']),
      'login_id' => trim($input['login_id']),
      'method' => trim($input['method']),
      'point' => trim($input['point']),
      'prediction_id' => trim($input['prediction_id']),
      'status' => APPLY,
    ];

    $obj_transaction_payment->insertTransactionPayment($arr_transaction_payment);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.add_transaction_payment_success"),
    ];
    return $result;
  }

  public function getListTransactionPayment()
  {
    $obj_transaction_payment = new TransactionPayment();
    $list_transaction_payment = $obj_transaction_payment->getTransactionPayment();
    return $list_transaction_payment;
  }


  public function getListTransactionPaymentAjax($input)
  {
    $obj_transaction_payment = new TransactionPayment();
    $list_transaction_payment = $obj_transaction_payment->getSearchTransactionPayment($input);
    return $list_transaction_payment;
  }

  public function TransactionPaymentDelete($id)
  {
    $obj_transaction_payment = new TransactionPayment();
    $obj_transaction_payment->deleteTransactionPayment($id);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.delete_record_success"),
    ];
    return $result;
  }

  public function summaryPaymentDaily($year, $month)
  {
    $obj_transaction_payment = new TransactionPayment();
    $data = $obj_transaction_payment->getSummaryPaymentDaily($year, $month);
    return $data;
  }

  public function summaryPaymentWeekly($start_week, $end_week)
  {
    $obj_transaction_payment = new TransactionPayment();
    $data = $obj_transaction_payment->getSummaryPaymentWeekly($start_week, $end_week);

    return $data;
  }
}