<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use Modules\Horserace\Entities\Prediction;
use Modules\Horserace\Entities\PredictionType;
use Modules\Horserace\Entities\TransactionPayment;
use Modules\Horserace\Entities\User;
use Modules\Horserace\Entities\UserAccessPrediction;
use Modules\Horserace\Entities\UserStage;
use Modules\Horserace\Entities\UserActivity;

class PredictionRepositories
{
    public function storePrediction($input)
    {
        $obj_prediction = new Prediction();
        $obj_pre_type = new PredictionType();

        // Save data
        $arr_prediction = [
            "name" => trim($input["name"]),
            "member_level" => isset($input["member_level"]) ? trim($input["member_level"]) : MEMBER_LEVEL_TRIAL,
            "prediction_type" => isset($input["prediction_type"]) ? trim($input["prediction_type"]) : null,
            "default_point" => trim($input["default_point"]),
            "status" => trim($input["status"]),
            //"content" => $input["content"],
            "after_buy" => $input["after_buy"],
            "result" => $input["result"],
            "display_order" => trim($input["display_order"]),
            "start_time" => $input["start_time"],
            "end_time" => $input["end_time"],
            "info_start_time" => $input["info_start_time"],
            "finish_recruit_time" => $input["prediction_finish_recruit_time"],
        ];

        // User stage
        $user_stage = '0,';
        if (isset($input["user_stage_id"])) {
            foreach ($input["user_stage_id"] as $id) {
                $user_stage = $user_stage . $id . ',';
            }
        }
        $arr_prediction["user_stage_id"] = $user_stage;

        // check isset file upload
        if (isset($input['img_banner'])) {
            //File::delete(public_path('upload/career'), $name_image);
            $time = \Carbon\Carbon::now()->timestamp;
            $name_image = $time . '_' . $input['img_banner']->getClientOriginalName();
            $input['img_banner']->move(public_path('uploads/prediction'), $name_image);
            $arr_prediction['img_banner'] = '/uploads/prediction/' . $name_image;
        }

        // Set image default
        if (!isset($arr_prediction['img_banner'])) {
            // When edit prediction
            $check_pre_edit = false;
            if ((integer) $input["id"] != 0) {
                $prediction = $obj_prediction->getPredictionById(trim($input["id"]));

                $check_pre_edit = (integer) ($prediction->prediction_type) != (integer) ($arr_prediction["prediction_type"]) ?
                true : false;
            }

            // Banner default when create
            if (((integer) $input["id"] == 0 || $check_pre_edit) && isset($input["prediction_type"])) {
                $type = (integer) trim($input["prediction_type"]);
                $list_pre_type = $obj_pre_type->getPredictionType();
                $arr_pre_type = array();
                foreach ($list_pre_type as $item) {
                    $arr_pre_type[$item->id] = (array) $item;
                }
                $arr_prediction['img_banner'] = $arr_pre_type[$type]["image"];
            }
        }

        if ($input["id"] != 0) {
            // Edit
            $arr_prediction["deleted_flg"] = isset($input["deleted_flg"]) ? DELETED_ENABLE : DELETED_DISABLE;
            $obj_prediction->updatePrediction(trim($input["id"]), $arr_prediction);
            $result = [
                "status" => "success",
                "message" => __("horserace::be_msg.edit_prediction_success"),
            ];
        } else {
             // Create
            $prediction_id_insert = $obj_prediction->insertPrediction($arr_prediction);
            $result = [
                "status" => "success",
                "message" => __("horserace::be_msg.add_prediction_success"),
            ];
            $result['prediction_id_insert'] = $prediction_id_insert; 
        }

        return $result;
    }

    public function getPredictionById($id_prediction)
    {
        $obj_prediction = new Prediction();
        $prediction = $obj_prediction->getPredictionById($id_prediction);

        // User stage
        $user_stage = explode(",", $prediction->user_stage_id);

        $arr_user_stage = array();
        foreach ($user_stage as $item) {
            $arr_user_stage[$item] = $item;
        }

        $prediction->arr_user_stage = $arr_user_stage;

        // Check img default
        $prediction->img_default = true;
        if (strpos($prediction->img_banner, "prediction_type") === false) {
            $prediction->img_default = false;
        }
        return $prediction;
    }

    public function getPrediction()
    {
        $obj_prediction = new Prediction();
        $obj_user_stage = new UserStage();
        $list_prediction = $obj_prediction->getAllActivePredictionsWithType();

        // User stage
        $list_user_stage = $obj_user_stage->getUserStage();
        $arr_user_stage = array();
        foreach ($list_user_stage as $item) {
            $arr_user_stage[$item->id] = $item;
        }

        // Stage to string
        foreach ($list_prediction as $key => $user) {
            $stage = explode(",", $user->user_stage_id);
            $user_stage_str = '';
            foreach ($stage as $item) {
                if (isset($arr_user_stage[$item])) {
                    $user_stage_str .= $arr_user_stage[$item]->name . ', ';
                }
            }
            $list_prediction[$key]->user_stage_str = rtrim($user_stage_str, ", ");
        }

        return $list_prediction;
    }

    public function getPredictionAjax($input)
    {
      $obj_prediction = new Prediction();
      $obj_user_stage = new UserStage();
      $list_prediction = $obj_prediction->getSearchAllActivePredictionsWithType($input);

      // User stage
      $list_user_stage = $obj_user_stage->getUserStage();
      $arr_user_stage = array();
      foreach ($list_user_stage as $item) {
        $arr_user_stage[$item->id] = $item;
      }

      // Stage to string
      foreach ($list_prediction['result'] as $key => $user) {
        $stage = explode(",", $user->user_stage_id);
        $user_stage_str = '';
        foreach ($stage as $item) {
          if (isset($arr_user_stage[$item])) {
            $user_stage_str .= $arr_user_stage[$item]->name . ', ';
          }
        }
        $list_prediction['result'][$key]->user_stage_str = rtrim($user_stage_str, ", ");
      }

      return $list_prediction;
    }

    public function deletePrediction($id_prediction)
    {
        $obj_prediction = new Prediction();
        $obj_prediction->deletePrediction($id_prediction);
        $result = [
            "status" => "success",
            "message" => __("horserace::be_msg.deleted_prediction"),
        ];

        return $result;
    }

    public function feGetPrediction($id_user, $member_level)
    {
        $obj_user = new User();
        $obj_prediction = new Prediction();
        $obj_user_access_prediction = new UserAccessPrediction();
        $list_prediction = $obj_prediction->getPredictionPublicMemberLevel($member_level);

        // Check user stage
        $user = $obj_user->getUserById($id_user);
        // Check user have prediction
        $user_stage = explode(SEPARATE, $user->user_stage_id);
        array_shift($user_stage);
        $user_stage = array_combine($user_stage, $user_stage);

        foreach ($list_prediction as $key => $prediction) {
            $pre_user_stage = explode(SEPARATE, $prediction->user_stage_id);
            $remove_pre = true;
            foreach ($pre_user_stage as $item) {
                if (isset($user_stage[$item])) {
                    $remove_pre = false;
                    break;
                }
            }
            // Remove prediction user not show
            if ($remove_pre) {
                unset($list_prediction[$key]);
            }
        }

        foreach ($list_prediction as $prediction) {
            // Check user have access
            if ($obj_user_access_prediction->haveAccessPrediction($id_user, $prediction->id)) {
                // Update
                $obj_user_access_prediction->addAccessPrediction($id_user, $prediction->id);
            } else {
                // Add
                $arr_user_access = [
                    "user_id" => $id_user,
                    "prediction_id" => $prediction->id,
                    "number_access" => 1,
                ];
                $obj_user_access_prediction->insertUserAccessPrediction($arr_user_access);
                $obj_prediction->addAccessPrediction($prediction->id);
            }
            // User have buy
            $prediction->user_buy = NOT_BUY_PREDICTION;
            if ($obj_user_access_prediction->haveBuyPrediction($id_user, $prediction->id)) {
                // Update
                $prediction->user_buy = BUY_PREDICTION;
            }

            // user can buy
            $now = strtotime(\Carbon\Carbon::now()->toDateTimeString());
            $public_start_time = strtotime($prediction->start_time);
            $public_end_time = strtotime($prediction->end_time);
            $info_start_time = strtotime($prediction->info_start_time);

            $prediction->user_can_buy = USER_CAN_NOT_BUY;
            if (($prediction->status == PREDICTION_STATUS_OPEN ||
                $prediction->status == PREDICTION_STATUS_REMAIN) &&
                ($public_start_time < $now && $info_start_time > $now)) {
                $prediction->user_can_buy = USER_CAN_BUY;
            }

            // Show result or after buy
            $prediction->show = "content";
            if (($prediction->user_buy == BUY_PREDICTION) &&
                ($public_start_time < $now && $info_start_time > $now)) {
                $prediction->show = "after_buy";
            }

            if (($prediction->user_buy == BUY_PREDICTION) &&
                ($info_start_time < $now && $public_end_time > $now)) {
                $prediction->show = "result";
            }

            // Change status result
            if ($prediction->show == "result") {
                $obj_user_access_prediction->accessResultUserAccessPrediction($id_user, $prediction->id);
            }

        }

        return $list_prediction;
    }

    public function buyPrediction($user_id, $prediction_id, $admin_add = false, $point_payment = 0)
    {
        $obj_prediction = new Prediction();
        $obj_user = new User();
        $obj_trans_payment = new TransactionPayment();
        $obj_user_access_prediction = new UserAccessPrediction();
        $obj_user_activity_repositories = new UserActivityRepositories();

        $prediction = $obj_prediction->getPredictionById($prediction_id);
        $user = $obj_user->getDetailUserById($user_id);

        $result=[];
        // Check member level
        if (($user->member_level < $prediction->member_level) &&
            ($prediction->member_level != MEMBER_SPECIAL))
        {
            $obj_user_access_prediction->changeErrorBuyPrediction($user_id, $prediction_id);
            $level = memberLevelStr($user->member_level);
            $result = [
                "error" => "member_level",
                "status" => "danger",
                'message' => __("horserace::be_msg.error_member_level", ['level' => $level]),
            ];
            return $result;
        } 

        $user_buy_pre = $obj_user_access_prediction->haveBuyPrediction($user_id, $prediction_id);
        if ($user_buy_pre)
        {
            $result = [
                "error" => "exist",
                "status" => "danger",
                "message" => __("horserace::be_msg.user_have_buy_prediction"),
            ];
            return $result;
        }

        if (($admin_add == false && $user->point >= $prediction->default_point) ||
            ($admin_add == true && $user->point >= $point_payment))
        {
            $arr_trans_payment = [
                'user_id' => $user_id,
                'login_id' => $user->login_id,
                'member_level' => $user->member_level,
                'point' => $admin_add == true ? $point_payment : $prediction->default_point,
                'prediction_id' => $prediction->id,
                'prediction_name' => $prediction->name,
                'status' => APPLY,
            ];
            $id_trans_payment = $obj_trans_payment->insertTransactionPayment($arr_trans_payment);                        
            $obj_user_access_prediction->changeBuyPrediction($user_id, $prediction_id);
            $user_buy_pre = $obj_user_access_prediction->haveBuyPrediction($user_id, $prediction_id);            
            if($user_buy_pre)
            {
                // Update point user
                if ($admin_add == true) 
                {
                    // Admin add user buy prediction
                    $obj_user_activity_repositories->paymentPoint($user_id, $point_payment);
                } 
                else 
                {
                    // Frontend user buy prediction
                    $obj_user_activity_repositories->paymentPoint($user_id, $prediction->default_point);
                }

                if(count($obj_trans_payment->getTransactionByUserIdAndPredictionIdDuplicate($user_id, $prediction_id)) > 1)
                {
                    $obj_user_activity = new UserActivity();
                    $user_activity = $obj_user_activity->getUserActivityByUserId($user_id);
                    
                    $arr_user_activity = [
                        "point" => $user_activity->point +($admin_add? (integer) ($point_payment):$prediction->default_point),
                        "point_payment" => $user_activity->point_payment - ($admin_add? (integer) ($point_payment):$prediction->default_point),
                        "payment_number" => $user_activity->payment_number - 1,
                        "last_payment_time" => \Carbon\Carbon::now()->toDateTimeString(),
                    ];
                    $obj_user_activity->updateUserActivity($user_id, $arr_user_activity);
                    $arr_trans_payment['deleted_flg'] = DELETED_ENABLE;
                    //if($id_trans_payment!=null && $id_trans_payment>0)
                    $obj_trans_payment->updateTransactionPayment($id_trans_payment , $arr_trans_payment);
                }
                if(count($obj_trans_payment->getTransactionByUserIdAndPredictionIdDuplicate($user_id, $prediction_id))==0)
                {
                    $obj_user_access_prediction->changeErrorBuyPrediction($user_id, $prediction_id);
                    $result = [
                        "error" => "exist",
                        "status" => "danger",
                        "message" => __("horserace::be_msg.user_have_buy_prediction"),
                    ];
                    return $result;
                }

                $obj_user_activity = new UserActivity();
                $user_activity = $obj_user_activity->getUserActivityByUserId($user_id);

                if($user_activity->point <0)
                {
                    $arr_user_activity = [
                        "point" => $user_activity->point +($admin_add? (integer) ($point_payment):$prediction->default_point),
                        "point_payment" => $user_activity->point_payment - ($admin_add? (integer) ($point_payment):$prediction->default_point),
                        "payment_number" => $user_activity->payment_number - 1,
                        "last_payment_time" => \Carbon\Carbon::now()->toDateTimeString(),
                    ];
                    $obj_user_activity->updateUserActivity($user_id, $arr_user_activity);
                    $obj_user_access_prediction->changeErrorBuyPrediction($user_id, $prediction_id);
                    $result = [
                        "error" => "point",
                        "status" => "danger",
                        "message" => __("horserace::be_msg.user_not_enough_point"),
                    ];
                    return $result;
                }   
                // Update prediction
                $obj_prediction->addBuyPrediction($prediction_id);
                $result["status"] = "success";
                $result["message"] = __("horserace::be_msg.buy_prediction_success");
                return $result;      
            }
        }
        else 
        {
            $obj_user_access_prediction->changeErrorBuyPrediction($user_id, $prediction_id);

            $result = [
                "error" => "point",
                "status" => "danger",
                "message" => __("horserace::be_msg.user_not_enough_point"),
            ];
        }
        return $result;
    }

    public function getPredictionOpen()
    {
        $obj_prediction = new Prediction();
        $list_prediction = $obj_prediction->getPredictionOpen();
        return $list_prediction;
    }

    public function addUserBuyPrediction($input)
    {
        $obj_user = new User();
        $obj_user_access_prediction = new UserAccessPrediction();

        $login_id = trim($input["login_id"]);
        $point = trim($input["point"]);
        $prediction_id = trim($input["prediction_id"]);

        // Check login id
        $user = $obj_user->getUserByLoginId($login_id);
        if (is_null($user)) {
            $result = [
                "status" => "danger",
                "message" => __("horserace::be_msg.login_id_not_found"),
            ];

            return $result;
        }

        // Check user have buy it
        $user_id = $user->id;
        $user_buy_pre = $obj_user_access_prediction->haveBuyPrediction($user_id, $prediction_id);
        if ($user_buy_pre) {
            $result = [
                "status" => "danger",
                "message" => __("horserace::be_msg.user_have_buy_prediction"),
            ];

            return $result;
        }

        // Add user buy
        $result = $this->buyPrediction($user_id, $prediction_id, true, $point);
        return $result;
    }

    public function feGetPredictionDetail($user_id, $prediction_id)
    {
        $obj_prediction = new Prediction();
        $obj_user_access_prediction = new UserAccessPrediction();

        $prediction = $obj_prediction->getPredictionById($prediction_id);

        // Check user have access
        $prediction->user_buy = NOT_BUY_PREDICTION;
        if ($obj_user_access_prediction->haveBuyPrediction($user_id, $prediction->id)) {
            // Update
            $prediction->user_buy = BUY_PREDICTION;
        }

        // user can buy
        $now = strtotime(\Carbon\Carbon::now()->toDateTimeString());
        $public_start_time = strtotime($prediction->start_time);
        $public_end_time = strtotime($prediction->end_time);
        $info_start_time = strtotime($prediction->info_start_time);

        $prediction->user_can_buy = USER_CAN_NOT_BUY;
        if (($prediction->status == PREDICTION_STATUS_OPEN ||
            $prediction->status == PREDICTION_STATUS_REMAIN) &&
            ($public_start_time < $now && $info_start_time > $now)) {
            $prediction->user_can_buy = USER_CAN_BUY;
        }

        // Show result or after buy
        $prediction->show = "content";
        if (($prediction->user_buy == BUY_PREDICTION) &&
            ($public_start_time < $now && $info_start_time > $now)) {
            $prediction->show = "after_buy";
        }

        if (($prediction->user_buy == BUY_PREDICTION) &&
            ($info_start_time < $now && $public_end_time > $now)) {
            $prediction->show = "result";
        }

        // Change status result
        if ($prediction->show == "result") {
            $obj_user_access_prediction->accessResultUserAccessPrediction($user_id, $prediction->id);
        }

        $result["status"] = "success";
        $result["prediction"] = $prediction;

        return $result;
    }

    public function feGetPredictionByOpen($id_user, $member_level)
    {
        $obj_user = new User();
        $obj_prediction = new Prediction();
        $list_prediction = $obj_prediction->getPredictionOpenMemberLevel($member_level);

        // Check user stage
        $user = $obj_user->getUserById($id_user);
        // Check user have prediction
        $user_stage = explode(SEPARATE, $user->user_stage_id);
        array_shift($user_stage);
        $user_stage = array_combine($user_stage, $user_stage);

        foreach ($list_prediction as $key => $prediction) {
            $pre_user_stage = explode(SEPARATE, $prediction->user_stage_id);
            $remove_pre = true;
            foreach ($pre_user_stage as $item) {
                if (isset($user_stage[$item])) {
                    $remove_pre = false;
                    break;
                }
            }
            // Remove prediction user not show
            if ($remove_pre) {
                unset($list_prediction[$key]);
            }
        }

        return $list_prediction;
    }

    public function feGetPredictionByPoint($id_user, $point)
    {
        $obj_user = new User();
        $obj_prediction = new Prediction();
        $obj_user_access_prediction = new UserAccessPrediction();
        $list_prediction = $obj_prediction->getPredictionPublicPoint($point);

        // Check user stage
        $user = $obj_user->getUserById($id_user);
        // Check user have prediction
        $user_stage = explode(SEPARATE, $user->user_stage_id);
        array_shift($user_stage);
        $user_stage = array_combine($user_stage, $user_stage);

        foreach ($list_prediction as $key => $prediction) {
            $pre_user_stage = explode(SEPARATE, $prediction->user_stage_id);
            $remove_pre = true;
            foreach ($pre_user_stage as $item) {
                if (isset($user_stage[$item])) {
                    $remove_pre = false;
                    break;
                }
            }
            // Remove prediction user not show
            if ($remove_pre) {
                unset($list_prediction[$key]);
            }
        }

        foreach ($list_prediction as $prediction) {
            // Check user have access
            if ($obj_user_access_prediction->haveAccessPrediction($id_user, $prediction->id)) {
                // Update
                $obj_user_access_prediction->addAccessPrediction($id_user, $prediction->id);
            } else {
                // Add
                $arr_user_access = [
                    "user_id" => $id_user,
                    "prediction_id" => $prediction->id,
                    "number_access" => 1,
                ];
                $obj_user_access_prediction->insertUserAccessPrediction($arr_user_access);
                $obj_prediction->addAccessPrediction($prediction->id);
            }
            // User have buy
            $prediction->user_buy = NOT_BUY_PREDICTION;
            if ($obj_user_access_prediction->haveBuyPrediction($id_user, $prediction->id)) {
                // Update
                $prediction->user_buy = BUY_PREDICTION;
            }

            // user can buy
            $now = strtotime(\Carbon\Carbon::now()->toDateTimeString());
            $public_start_time = strtotime($prediction->start_time);
            $public_end_time = strtotime($prediction->end_time);
            $info_start_time = strtotime($prediction->info_start_time);

            $prediction->user_can_buy = USER_CAN_NOT_BUY;
            if (($prediction->status == PREDICTION_STATUS_OPEN ||
                $prediction->status == PREDICTION_STATUS_REMAIN) &&
                ($public_start_time < $now && $info_start_time > $now)) {
                $prediction->user_can_buy = USER_CAN_BUY;
            }

            // Show result or after buy
            $prediction->show = "content";
            if (($prediction->user_buy == BUY_PREDICTION) &&
                ($public_start_time < $now && $info_start_time > $now)) {
                $prediction->show = "after_buy";
            }

            if (($prediction->user_buy == BUY_PREDICTION) &&
                ($info_start_time < $now && $public_end_time > $now)) {
                $prediction->show = "result";
            }

            // Change status result
            if ($prediction->show == "result") {
                $obj_user_access_prediction->accessResultUserAccessPrediction($id_user, $prediction->id);
            }

        }

        return $list_prediction;
    }

    public function feGetPredictionByType($id_user, $type_code)
    {
        $obj_user = new User();
        $obj_prediction = new Prediction();
        $obj_user_access_prediction = new UserAccessPrediction();
        $PredictionTypeModel = new PredictionType();

        $prediction_type = $PredictionTypeModel->getPredictionTypeByCode($type_code);
        $list_prediction = $obj_prediction->getPredictionPublicType($prediction_type->id);

        ////////////////////////////////////////////////////////
        // Check user stage
        $user = $obj_user->getUserById($id_user);
        // Check user have prediction
        $user_stage = explode(SEPARATE, $user->user_stage_id);
        array_shift($user_stage);
        $user_stage = array_combine($user_stage, $user_stage);

        foreach ($list_prediction as $key => $prediction) {
            $pre_user_stage = explode(SEPARATE, $prediction->user_stage_id);
            $remove_pre = true;
            foreach ($pre_user_stage as $item) {
                if (isset($user_stage[$item])) {
                    $remove_pre = false;
                    break;
                }
            }
            // Remove prediction user not show
            if ($remove_pre) {
                unset($list_prediction[$key]);
            }
        }

        foreach ($list_prediction as $prediction) {
            // Check user have access
            if ($obj_user_access_prediction->haveAccessPrediction($id_user, $prediction->id)) {
                // Update
                $obj_user_access_prediction->addAccessPrediction($id_user, $prediction->id);
            } else {
                // Add
                $arr_user_access = [
                    "user_id" => $id_user,
                    "prediction_id" => $prediction->id,
                    "number_access" => 1,
                ];
                $obj_user_access_prediction->insertUserAccessPrediction($arr_user_access);
                $obj_prediction->addAccessPrediction($prediction->id);
            }
            // User have buy
            $prediction->user_buy = NOT_BUY_PREDICTION;
            if ($obj_user_access_prediction->haveBuyPrediction($id_user, $prediction->id)) {
                // Update
                $prediction->user_buy = BUY_PREDICTION;
            }

            // user can buy
            $now = strtotime(\Carbon\Carbon::now()->toDateTimeString());
            $public_start_time = strtotime($prediction->start_time);
            $public_end_time = strtotime($prediction->end_time);
            $info_start_time = strtotime($prediction->info_start_time);

            $prediction->user_can_buy = USER_CAN_NOT_BUY;
            if (($prediction->status == PREDICTION_STATUS_OPEN ||
                $prediction->status == PREDICTION_STATUS_REMAIN) &&
                ($public_start_time < $now && $info_start_time > $now)) {
                $prediction->user_can_buy = USER_CAN_BUY;
            }

            // Show result or after buy
            $prediction->show = "content";
            if (($prediction->user_buy == BUY_PREDICTION) &&
                ($public_start_time < $now && $info_start_time > $now)) {
                $prediction->show = "after_buy";
            }

            if (($prediction->user_buy == BUY_PREDICTION) &&
                ($info_start_time < $now && $public_end_time > $now)) {
                $prediction->show = "result";
            }

            // Change status result
            if ($prediction->show == "result") {
                $obj_user_access_prediction->accessResultUserAccessPrediction($id_user, $prediction->id);
            }

        }

        $prediction_type->table_params = json_decode($prediction_type->prediction_type_params);

        return [
            'prediction_type' => $prediction_type,
            'list_prediction' => $list_prediction
        ];
    }

}
