<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use DateTime;
use hasFile;
use Modules\Horserace\Entities\Prediction;
use Modules\Horserace\Entities\TransactionPayment;
use Modules\Horserace\Entities\User;
use Modules\Horserace\Entities\UserAccessPrediction;
use Modules\Horserace\Entities\Venue;

class UserAccessPredictionRepositories
{
  public function getUserAccessByPredictionId($prediction_id)
  {
    $obj_user_access_pre = new UserAccessPrediction();
    $obj_user = new User();

    // Get user access
    $data = $obj_user_access_pre->getUserAccessByPredictionId($prediction_id);

    // Get info user
    foreach ($data as $key => $item) {
      $user = $obj_user->getUserById($item->user_id);
      $data[$key]->info = $user;
    }

    return $data;
  }

  public function getUserBuyByPredictionId($prediction_id)
  {
    $obj_user_access_pre = new UserAccessPrediction();
    $obj_user = new User();
    $obj_user_trans_payment = new TransactionPayment();

    // Get user access
    $data = $obj_user_access_pre->getUserBuyByPredictionId($prediction_id);

    // Get info user
    foreach ($data as $key => $item) {
      $user = $obj_user->getUserById($item->user_id);
      $data[$key]->info = $user;
      $data[$key]->trans = $obj_user_trans_payment->getTransactionByUserIdAndPredictionId($item->user_id, $prediction_id);
    }

    return $data;
  }

  public function deleteUserBuyPrediction($input)
  {
    $number_checked = 0;
    if (isset($input["user_buy_id"])) {
      $obj_user_access_pre = new UserAccessPrediction();
      $obj_prediction = new Prediction();
      $prediction_id = trim($input["prediction_id"]);

      // Get id user access prediction
      $list_id = $input["user_buy_id"];

      // Update status buy
      foreach ($list_id as $id) {
        $arr_update["buy"] = NOT_BUY_PREDICTION;
        $obj_user_access_pre->updateUserAccessPrediction($id, $arr_update);
      }

      // Update number user buy
      $number_checked = (integer)(count($list_id));
      $prediction = $obj_prediction->getPredictionById($prediction_id);
      $arr_pre_update["number_buyer"] = (integer)($prediction->number_buyer) - (integer)(count($list_id));
      $obj_prediction->updatePrediction($prediction_id, $arr_pre_update);
    }

    $result = [
      'status' => 'success',
      'message' => __("horserace::be_msg.deleted_user_buy_prediction", ['number_checked' => $number_checked]),
    ];
    return $result;
  }
}