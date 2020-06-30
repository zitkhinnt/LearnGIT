<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\UserActivity;
use Modules\Horserace\Entities\MailRegisterDetail;
use Modules\Horserace\Entities\MailTemplate;
use Modules\Horserace\Entities\User;

class UserActivityRepositories
{
    public function updatePoint($user_id)
    {
        $obj_user_activity = new UserActivity();
        $user_activity = $obj_user_activity->getUserActivityByUserId($user_id);

        // Update point
        $point = (integer) ($user_activity->point_deposit) + (integer) ($user_activity->point_gift) - (integer) ($user_activity->point_payment);
        $arr_user_activity = [
            "point" => $point,
        ];
        $obj_user_activity->updateUserActivity($user_id, $arr_user_activity);
    }

    public function giftPoint($user_id, $point_gift)
    {
        $obj_user_activity = new UserActivity();
        $user_activity = $obj_user_activity->getUserActivityByUserId($user_id);

        // Update point
        $point_gift_save = (integer) ($user_activity->point_gift) + (integer) ($point_gift);
        $point = (integer) ($user_activity->point_deposit) + (integer) ($point_gift_save) - (integer) ($user_activity->point_payment);
        $arr_user_activity = [
            "point" => $point,
            "point_gift" => $point_gift_save,
        ];
        $obj_user_activity->updateUserActivity($user_id, $arr_user_activity);
    }

    public function paymentPoint($user_id, $point_payment)
    {
        $obj_user_activity = new UserActivity();
        $user_activity = $obj_user_activity->getUserActivityByUserId($user_id);

        // Update point
        $point_payment_save = (integer) ($user_activity->point_payment) + (integer) ($point_payment);
        $point = (integer) ($user_activity->point_deposit) + (integer) ($user_activity->point_gift) - (integer) ($point_payment_save);
        $payment_number = (integer) ($user_activity->payment_number) + 1;

        // Update user activity
        $arr_user_activity = [
            "point" => $point,
            "point_payment" => $point_payment_save,
            "payment_number" => $payment_number,
            "last_payment_time" => \Carbon\Carbon::now()->toDateTimeString(),
        ];

        // First payment
        if (is_null($user_activity->first_payment_time)) {
            $arr_user_activity["first_payment_time"] = \Carbon\Carbon::now()->toDateTimeString();
        }

        $obj_user_activity->updateUserActivity($user_id, $arr_user_activity);
    }

    public function depositPoint($user_id, $point_deposit, $amount_deposit)
    {
        $obj_user_activity = new UserActivity();
        $user_activity = $obj_user_activity->getUserActivityByUserId($user_id);

        // Update point
        $point_deposit_save = (integer) ($user_activity->point_deposit) + (integer) ($point_deposit);
        $point = (integer) ($point_deposit_save) + (integer) ($user_activity->point_gift) - (integer) ($user_activity->point_payment);
        $deposit_number = (integer) ($user_activity->deposit_number) + 1;
        $deposit_amount = (integer) ($user_activity->deposit_amount) + $amount_deposit;

        // Update user activity
        $arr_user_activity = [
            "point" => $point,
            "point_deposit" => $point_deposit_save,
            "last_deposit_time" => \Carbon\Carbon::now()->toDateTimeString(),
            "deposit_number" => $deposit_number,
            "deposit_amount" => $deposit_amount,
        ];

        //First deposit
        if (is_null($user_activity->first_deposit_time)) {
            $arr_user_activity["first_deposit_time"] = \Carbon\Carbon::now()->toDateTimeString();
            // Update member level
    //      $obj_user = new User();
    //      $arr_user["member_level"] = MEMBER_LEVEL_GOLD;
    //      $obj_user->updateUser($user_id, $arr_user);
        }

        $obj_user_activity->updateUserActivity($user_id, $arr_user_activity);
    }

    public function getLoginNumber($user_id)
    {
        $obj_user_activity = new UserActivity();
        $data = $obj_user_activity->getUserActivityByUserId($user_id);
        return $data;
    }

    public function userActivityUpdate($user_id, $input)
    {
        $obj_user_activity = new UserActivity();
        $obj_user_activity->updateUserActivity($user_id, $input);
    }

    public function addLoginUser($input)
    {
        $obj_user_activity = new UserActivity();
        $user_activity = $obj_user_activity->getUserActivityByUserId(trim($input["user_id"]));

        // Update user_activity
        $arr_user_activity = [
            "ip" => $input["ip"],
            "user_agent" => $input["user_agent"],
            "login_number" => (integer) $user_activity->login_number + 1,
            "last_login_time" => \Carbon\Carbon::now()->toDateTimeString(),
        ];
        $obj_user_activity->updateUserActivity($user_activity->user_id, $arr_user_activity);
    }

    public function firstUserActivityByUser_id($user_id)
    {
        $obj_user_activity = new UserActivity();
        $data = $obj_user_activity->getUserActivityByUserId($user_id);
        return $data;
    }

}
