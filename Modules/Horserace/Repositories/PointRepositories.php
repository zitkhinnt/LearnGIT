<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use DateTime;
use hasFile;
use Modules\Horserace\Entities\Point;

class PointRepositories
{
  public function pointStore($input)
  {
    $obj_point = new Point();
    $arr_point = [
      'point' => trim($input['point']),
      'price' => trim($input['price']),
    ];

    if (trim($input['id']) == 0) {
      $obj_point->insertPoint($arr_point);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_point_success"),
      ];
    } else {
      $obj_point->updatePoint(trim($input['id']), $arr_point);
      $result = [
        'status' => 'success',
        'message' => __("horserace::be_msg.edit_point_success"),
      ];
    }
    return $result;
  }

  public function getEditPoint($id)
  {
    $obj_point = new Point();
    $data_edit_point = $obj_point->getPointById($id);
    return $data_edit_point;
  }

  public function getListPoint()
  {
    $obj_point = new Point();
    $list_point = $obj_point->getPoint();
    return $list_point;
  }

  public function pointDelete($id)
  {
    $obj_point = new Point();
    $obj_point->deletePoint($id);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.deleted_point_success"),
    ];
    return $result;
  }

  public function getPoinPackageByMoney($money) {
    return Point::where('deleted_flg', DELETED_DISABLE)
      ->where('price', $money)
      ->first();
  }

}