<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class FrontendImage
{
  protected $table = 'frontend_image';

  public function storeImage($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function updateImage($code ,$data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)
      ->where('code', $code)
      ->where('deleted_flg', DELETED_DISABLE)
      ->update($data);
  }

  public function getImageByCode()
  {
    return DB::table($this->table)
    ->where('code', IMAGE_FRONTEND_CODE_ATTENTION)
    ->where('deleted_flg', DELETED_DISABLE)
    ->first();
  }

  public function getAllImage()
  {
    return DB::table($this->table)
    ->where('deleted_flg', DELETED_DISABLE)
    ->get();
  }
}
