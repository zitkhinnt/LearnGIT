<?php

namespace Modules\Horserace\Entities;

use Illuminate\Database\Eloquent\Model as Model;
use Illuminate\Support\Facades\DB;

class Page extends Model
{
    protected $table = 'page';

    protected $fillable = [
        'id',
        'name',
        'code',
        'link',
        'source',
        'deleted_flg',
    ];

    public function insertPage($data)
    {
        $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
        $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
        return DB::table($this->table)->insert($data);
    }

    public function getPage()
    {
        return DB::table($this->table)
            ->where($this->table . '.deleted_flg', 0)
            ->orderBy('id', 'DESC')
            ->get()
            ->toArray();
    }

    public function getPageById($id)
    {
        return DB::table($this->table)->find($id);
    }
    public function getPageByCode($code)
    {
        return DB::table($this->table)->where($this->table. '.deleted_flg', DELETED_DISABLE)
        ->where($this->table. '.code', $code)
        ->first();
    }

    public function updatePage($id, $data)
    {
        $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();
        DB::table($this->table)
            ->where('id', $id)
            ->update($data);
    }

    public function deletePage($id)
    {
        $data['deleted_flg'] = 1;
        DB::table($this->table)
            ->where('id', $id)
            ->update($data);
    }
}
