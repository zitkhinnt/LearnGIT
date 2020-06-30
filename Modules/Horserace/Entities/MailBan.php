<?php

namespace Modules\Horserace\Entities;

use Illuminate\Support\Facades\DB;

class MailBan
{
    protected $table = 'mail_ban';

    public function insertMailBan($data)
    {
        $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
        return DB::table($this->table)->insert($data);
    }

    public function getMailBan()
    {
        return DB::table($this->table)
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->orderBy('id', 'DESC')
            ->get()
            ->toArray();
    }

    public function getMailBanById($id)
    {
        return DB::table($this->table)->find($id);
    }

    public function updateMailBan($id, $data)
    {
        $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
        DB::table($this->table)
            ->where('id', $id)
            ->update($data);
    }

    public function deleteMailBan($id)
    {
        $data['deleted_flg'] = DELETED_ENABLE;
        DB::table($this->table)
            ->where('id', $id)
            ->update($data);
    }

    public function isMailBan($mail)
    {
        $result = DB::table($this->table)
            ->where($this->table . '.mail', 'like', '%' . $mail . '%')
            ->where($this->table . '.deleted_flg', DELETED_DISABLE)
            ->first();

        return is_null($result) ? false : true;
    }
}
