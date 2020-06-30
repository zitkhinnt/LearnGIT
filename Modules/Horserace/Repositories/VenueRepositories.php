<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use DateTime;
use hasFile;
use Modules\Horserace\Entities\Venue;

class VenueRepositories
{
  public function venueStore($input)
  {
    $obj_venue = new Venue();
    $arr_venue = [
      'name' => trim($input['name']),
      'css' => trim($input['css']),
      'image' => trim($input['image']),
    ];
    if (trim($input['id']) == 0) {
      // Add
      $obj_venue->insertVenue($arr_venue);
      $result = [
        "status" => "success",
        "message" => __("horserace::be_msg.add_venue_success"),
      ];
    } else {
      // Edit
      $obj_venue->updateVenue(trim($input['id']), $arr_venue);
      $result = [
        'status' => 'success',
        'message' => __("horserace::be_msg.edit_venue_success"),
      ];
    }
    return $result;
  }

  public function getEditVenue($id)
  {
    $obj_venue = new Venue();
    $data_edit_venue = $obj_venue->getVenueById($id);
    return $data_edit_venue;
  }

  public function getListVenue()
  {
    $obj_venue = new Venue();
    $list_venue = $obj_venue->getVenue();
    return $list_venue;
  }

  public function venueDelete($id)
  {
    $obj_venue = new Venue();
    $obj_venue->deleteVenue($id);
    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.deleted_venue_success"),
    ];
    return $result;
  }

}