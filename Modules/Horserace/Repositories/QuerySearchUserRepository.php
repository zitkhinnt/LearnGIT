<?php

namespace Modules\Horserace\Repositories;

use Modules\Horserace\Entities\QuerySearchUser;
use Illuminate\Support\Facades\DB;

class QuerySearchUserRepository
{
  public function addQuerySearch($name, $query)
  {
    DB::beginTransaction();
    try {
      $model = new QuerySearchUser();
      $model->name = $name;
      $model->query = $query;
      $model->created_at = date('Y-m-d H:i:s');

      $model->save();
      DB::commit();
      return true;
    } catch (\Exception $e) {
      DB::rollBack();
      return false;
    }
  }

  public function updateQuerySearch($id, $name, $query)
  {
    if ($id == null || $id == '')
      return false;
    DB::beginTransaction();
    try {
      $model = QuerySearchUser::findOrFail($id);
      if ($model) {
        $model->name = $name;
        $model->query = $query;

        $model->save();
        DB::commit();

        return true;
      } else {
        return false;
      }
    } catch (\Exception $e) {
      DB::rollBack();
      return false;
    }
  }

  public function deleteQuery($id)
  {
    $model = QuerySearchUser::where('id', $id);
    if ($model) {
      $model->update(['deleted_flg' => 1]);
      return true;
    }
    return false;
  }

  public function getListQuery()
  {
    return DB::table('query_search_user')
      ->where('deleted_flg', '<>', 1)
      ->get();
  }
}
