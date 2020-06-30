<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use Modules\Horserace\Entities\User;
use Modules\Horserace\Entities\UserStage;

class UserStageRepositories
{
    public function UserStageStore($input)
    {
        $obj_user_stage = new UserStage();
        $arr_user_stage = [
            'name' => trim($input['name']),
            'stage' => trim($input['stage']),
        ];
        if (trim($input['id']) == 0) {
            // Add
            $obj_user_stage->insertUserStage($arr_user_stage);
            $result = [
                "status" => "success",
                "message" => __("horserace::be_msg.add_user_stage_success"),
            ];
        } else {
            // Edit
            $obj_user_stage->updateUserStage(trim($input['id']), $arr_user_stage);
            $result = [
                'status' => 'success',
                'message' => __("horserace::be_msg.edit_user_stage_success"),
            ];
        }
        return $result;
    }

    public function getEditUserStage($id)
    {
        $obj_user_stage = new UserStage();
        $data_edit_user_stage = $obj_user_stage->getUserStageById($id);
        return $data_edit_user_stage;
    }

    public function getListUserStage()
    {
        $obj_user_stage = new UserStage();
        $list_user_stage = $obj_user_stage->getUserStage();
        return $list_user_stage;
    }

    public function userStageDelete($id)
    {
        $obj_user_stage = new UserStage();
        $obj_user_stage->deleteUserStage($id);
        $result = [
            "status" => "success",
            "message" => __("horserace::be_msg.deleted_user_stage_success"),
        ];
        return $result;
    }

    public function addAllUserStage($input, $condition)
    {
        $obj_user = new User();
        if (isset($input["user_stage_id"])) {
            $list_user = $obj_user->searchUserByCondition($condition);
            foreach ($list_user as $user) {
                // User stage user
                $arr_user_stage = explode(SEPARATE, $user->user_stage_id);
                $arr_user_stage_add = array_values($input["user_stage_id"]);
                $array_stages = array_unique(array_merge($arr_user_stage, $arr_user_stage_add));
                ksort($array_stages);
                $user_stage_id = implode(SEPARATE, $array_stages);

                // Add user_stage_id
                $arr_user['user_stage_id'] = $user_stage_id;
                $stage_result = $obj_user->updateUser($user->id, $arr_user);

                khanh_log('user ::::' . $user->id . '::::update stage:::' . print_r($arr_user, true));
                khanh_log('change stage result:::' . $stage_result);
            }
        }

        $result = [
            "status" => "success",
            "message" => __("horserace::be_msg.add_all_user_stage_success"),
        ];
        return $result;
    }

    public function editAllUserStage($input, $condition)
    {
        $obj_user = new User();
        if (isset($input["user_stage_id"])) {
            $list_user = $obj_user->searchUserByCondition($condition);

            // User stage
            $arr_user = [];
            $arr_user_stage_edit = array_values($input["user_stage_id"]);
            $arr_user['user_stage_id'] = "0" . SEPARATE . implode(SEPARATE, $arr_user_stage_edit);

            // Update user
            foreach ($list_user as $user_item) {
                $obj_user->updateUser($user_item->id, $arr_user);
            }
        }

        $result = [
            "status" => "success",
            "message" => __("horserace::be_msg.edit_all_user_stage_success"),
        ];
        return $result;
    }

    public function deletedAllUserStage($input, $condition)
    {
        $obj_user = new User();
        if (isset($input["user_stage_id"])) {
            $list_user = $obj_user->searchUserByCondition($condition);

            // User stage for user.
            foreach ($list_user as $user) {
                $arr_user_stage = explode(SEPARATE, $user->user_stage_id);
                $user_stage_id = '';

                // Delete user_stage_id
                foreach ($arr_user_stage as $key => $value) {
                    if (isset($input["user_stage_id"][$value])) {
                        unset($arr_user_stage[$key]);
                    }
                }
                
                $arr_user = [];
                $arr_user['user_stage_id'] = implode(SEPARATE, $arr_user_stage);
                $obj_user->updateUser($user->id, $arr_user);
            }
        }

        $result = [
            "status" => "success",
            "message" => __("horserace::be_msg.deleted_all_user_stage_success"),
        ];
        return $result;
    }

    public function summaryNumberPeople()
    {
        $obj_user_stage = new UserStage();
        $obj_user = new User();
        $list_user_stage = $obj_user_stage->getUserStage();

        // Summary
        $summary = array();
        foreach ($list_user_stage as $item) {
            $summary[] = [
                "user_stage_name" => $item->name,
                "user_stage_stage" => $item->stage,
                "user_register" => $obj_user->countUserByUserStage($item->id),
            ];
        }

        return $summary;
    }
}
