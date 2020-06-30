<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class MailTemplate
{
  protected $table = 'mail_template';

  public function insertMailTemplate($data)
  {
    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    return DB::table($this->table)->insert($data);
  }

  public function getMailTemplate()
  {
    return DB::table($this->table)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->orderBy('id', 'DESC')
      ->get()
      ->toArray();
  }

  public function getMailTemplateById($id)
  {
    return DB::table($this->table)->find($id);
  }

  public function updateMailTemplate($id, $data)
  {
    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function deleteMailTemplate($id)
  {
    $data['deleted_flg'] = DELETED_ENABLE;
    DB::table($this->table)
      ->where('id', $id)
      ->update($data);
  }

  public function getMailTemplateByType($type)
  {
    return DB::table($this->table)
      ->where($this->table . '.type', $type)
      ->where($this->table . '.deleted_flg', DELETED_DISABLE)
      ->get()
      ->toArray();
  }
}
