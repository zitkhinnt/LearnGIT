<?php

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\Media;
use Modules\Horserace\Entities\MediaAccess;
use Modules\Horserace\Entities\UserDailyLoginHistory;
use Modules\Horserace\Entities\User;

class MediaAccessRepositories
{

  public function addMediaAccess($input)
  {
    $obj_media_access = new MediaAccess();
    $date = \Carbon\Carbon::now()->toDateTimeString();
    $now = date("Y-m-d", strtotime($date));

    // Media
    $obj_media = new Media();
    $media = $obj_media->getMediaByCode($input["media_code"]);

    if (!isset($media->id)) {
      $media = $obj_media->getMediaByCode(MEDIA_DEFAULT);
    }

    $arr_media_access = [
      "media_id" => $media->id,
      "media_code" => $media->code,
      "access_date" => $now
    ];

    // Check have login in date
    if ($obj_media_access->haveMediaAccess($media->id, $now)) {
      // Edit
      $media_access = $obj_media_access->getByMediaIdAndAccessDate($media->id, $now);
      $arr_media_access["number_access"] = (integer)$media_access->number_access + 1;
      $obj_media_access->updateMediaAccess($media_access->id, $arr_media_access);
    } else {
      // Add
      $arr_media_access["number_access"] = 1;
      $obj_media_access->insertMediaAccess($arr_media_access);
    }
  }

//  public function summaryMediaAccess($year, $month)
//  {
//    $obj_user_daily_login = new UserDailyLoginHistory();
//    $data = $obj_user_daily_login->getSummaryMediaAccess($year, $month);
//    return $data;
//  }
}