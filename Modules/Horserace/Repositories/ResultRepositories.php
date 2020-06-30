<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\Result;
use Modules\Horserace\Entities\Venue;

class ResultRepositories
{
  public function resultStore($input)
  {    
    $obj_result = new Result();
    $arr_result = [
      'course' => isset($input['course'])?trim($input['course']):null,
      'course_text' => trim($input['course_text']),
      'double' => trim($input['double']),
      'race_no_1_title' =>isset($input['race_no_1_title'])?trim($input['race_no_1_title']):'',
      'race_no_1_num' => trim($input['race_no_1_num']),
      'place_1' => trim($input['place_1']),
      'race_no_2_title' =>isset($input['race_no_2_title']) ? trim($input['race_no_2_title']) : '',
      'race_no_2_num' => isset($input['race_no_2_num']) ? trim($input['race_no_2_num']) : 0,
      'place_2' => isset($input['place_2']) ? trim($input['place_2']) : 0,
      'date' => trim($input['date']),
      'korogashi' => trim($input['korogashi']),
      'ticket_type' => trim($input['ticket_type']),
      'bike_number_1' => isset($input['bike_number_1']) ? trim($input['bike_number_1']) : 0,
      'bike_number_2' => isset($input['bike_number_2']) ? trim($input['bike_number_2']) : 0,
      'bike_number_3' => isset($input['bike_number_3']) ? trim($input['bike_number_3']) : 0,
      'bike_number_1_2' => isset($input['bike_number_1_2']) ? trim($input['bike_number_1_2']) : 0,
      'bike_number_2_2' => isset($input['bike_number_2_2']) ? trim($input['bike_number_2_2']) : 0,
      'bike_number_3_2' => isset($input['bike_number_3_2']) ? trim($input['bike_number_3_2']) : 0,
      'won_man' => isset($input['won_man']) ? trim($input['won_man']) : 0,
      'won_yen' => isset($input['won_yen']) ? trim($input['won_yen']) : 0,
    ];

    if (trim($input["id"]) != 0) {
      $obj_result->updateResult(trim($input["id"]), $arr_result);
      $result = [
        'status' => 'success',
        'message' => __("horserace::be_msg.edit_result_success"),
      ];
    } else {
      $obj_result->insertResult($arr_result);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_result_success"),
      ];
    }
    

    return $result;
  }

  public function getEditResult($id)
  {
    $obj_result = new Result();
    $data_edit_result = $obj_result->getResultById($id);
    return $data_edit_result;
  }

  public function getListResult()
  {
    $obj_result = new Result();
    $list_result = $obj_result->getResult();
    return $list_result;
  }

  public function getListSearchResult($input)
  {
    $obj_result = new Result();
    $list_result = $obj_result->getSearchResult($input);
    return $list_result;
  }

  public function getListResultPublic($input)
  {
    $input['page'] = isset($input['page']) ? $input['page'] : 0;

    $obj_result = new Result();
    $obj_venue = new Venue();
    $list_venue = $obj_venue->getVenue();
    $arr_venue = array();
    $arr_venue[0]["image"] = null;
    // Venue
    foreach ($list_venue as $venue) {
      $arr_venue[$venue->id] = (array)$venue;
    }

    // List result
    $list_result = $obj_result->getResultPublic($input['page'], PAGINATE_RESULT);

    if (isset($list_result["items"])) {
      foreach ($list_result["items"] as $key => $item) {
        $list_result["items"][$key]["place_1_img"] = $arr_venue[$item["place_1"]]["image"];
        $list_result["items"][$key]["place_2_img"] = $arr_venue[$item["place_2"]]["image"];
      }
    }

    // Check page
    if ($input['page'] != 1) {
      $list_result['currentPage'] = (int)$input['page'];
    }

    $data['result'] = $list_result;
    $data['input'] = $input;
    return $data;
  }


  public function resultDelete($id)
  {
    $obj_result = new Result();
    $obj_result->deleteResult($id);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.deleted_result_success"),
    ];
    return $result;
  }

  public function feGetBlogDetail($user_id, $result_id)
  {
    $obj_result = new Result();
    $result = $obj_result->getResultById($result_id);

    return $result;
  }

}