<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\Prediction;
use Modules\Horserace\Entities\PredictionResult;
use Modules\Horserace\Entities\MailRegister;
use Modules\Horserace\Entities\MailTemplate;
use Modules\Horserace\Entities\User;

class PredictionResultRepositories
{
  public function storePredictionResult($input)
  {
    $obj_prediction_result = new PredictionResult();

    // Save data
    $arr_prediction_result = [
      "race_name" => trim($input["race_name"]),
      "prediction_id" => trim($input["prediction_id"]),
      "venue_id" => trim($input["venue_id"]),
      "prediction_type" => trim($input["prediction_type"]),
      "race_no" => $input["race_no"],
      "type" => $input["type"],
      "hit_race" => $input["hit_race"],
      "amount" => $input["amount"],
      "race_date" => $input["race_date"],
      "reserve_datetime" => $input["reserve_datetime"],
      "content" => $input["content"],
    ];

    // check isset file upload
    if (isset($input['img_banner'])) {
      //File::delete(public_path('upload/career'), $name_image);
      $time = \Carbon\Carbon::now()->timestamp;
      $name_image = $time . '_' . $input['img_banner']->getClientOriginalName();
      $input['img_banner']->move(public_path('uploads/prediction_result'), $name_image);
      $arr_prediction_result['img_banner'] = '/uploads/prediction_result/' . $name_image;
    }

    if ($input["id"] != 0) {
      // Edit
      $obj_prediction_result->updatePredictionResult(trim($input["id"]), $arr_prediction_result);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.edit_prediction_result_success")
      ];
    } else {
      // Create
      $arr_prediction_result["send_mail"] = SEND_MAIL_NOT;

      $obj_prediction_result->insertPredictionResult($arr_prediction_result);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_prediction_result_success")
      ];
    }

    return $result;
  }

  public function getPredictionResultById($id_prediction_result)
  {
    $obj_prediction_result = new PredictionResult();
    $PredictionResult = $obj_prediction_result->getPredictionResultById($id_prediction_result);
    return $PredictionResult;
  }

  public function getPredictionResult()
  {
    $obj_prediction_result = new PredictionResult();
    $list_prediction_result = $obj_prediction_result->getPredictionResult();
    return $list_prediction_result;
  }

  public function deletePredictionResult($id_prediction_result)
  {
    $obj_prediction_result = new PredictionResult();
    $obj_prediction_result->deletePredictionResult($id_prediction_result);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.delete_prediction_result"),
    ];

    return $result;
  }

  public function getPredictionResultAndPrediction()
  {
    $obj_prediction = new Prediction();
    $obj_prediction_result = new PredictionResult();

    // Get prediction
    $list_prediction = $obj_prediction->getPrediction();

    // Get result
    foreach ($list_prediction as $key => $prediction) {
      $prediction_result = $obj_prediction_result->getResultByPredictionId($prediction->id);
      $list_prediction[$key]->result = $prediction_result;
    }

    return $list_prediction;
  }
}