<?php
/**
 * Created by PhpStorm.
 * User: khanh
 * Date: 10/11/2018
 * Time: 3:17 PM
 */

function khanh_log($log)
{
    file_put_contents(base_path() . '/storage/logs/khanh.log', date("r") . ":\n" . $log . "\n---\n", FILE_APPEND);
}

function nghia_log($log)
{
    file_put_contents(base_path() . '/storage/logs/nghia.log', date("r") . ":\n" . $log . "\n---\n", FILE_APPEND);
}

function api_log($log)
{
    file_put_contents(base_path() . '/storage/logs/api.log', date("r") . ":\n" . $log . "\n---\n", FILE_APPEND);
}

function mail_register_log($log)
{
    file_put_contents(base_path() . '/storage/logs/mail_register.log', date("r") . ":\n" . $log . "\n---\n", FILE_APPEND);
}

function mail_demon_log($log)
{
    file_put_contents(base_path() . '/storage/logs/mail_demon.log', date("r") . ":\n" . $log . "\n---\n", FILE_APPEND);
}

function mail_contact_log($log)
{
    file_put_contents(base_path() . '/storage/logs/mail_contact.log', date("r") . ":\n" . $log . "\n---\n", FILE_APPEND);
}

function mail_bulk_log($log)
{
    file_put_contents(base_path() . '/storage/logs/mail_bulk.log', date("r") . ":\n" . $log . "\n---\n", FILE_APPEND);
}

function menuActiveTag($menu)
{
    $list_tab = array();

    switch ($menu) {
        case 'user';
            $list_tab[] = 'admin.user';
            $list_tab[] = 'admin.user.add';
            $list_tab[] = 'admin.user.edit';
            $list_tab[] = 'admin.user.store';
            $list_tab[] = 'admin.user.update';
            $list_tab[] = 'admin.user.search';
            $list_tab[] = 'admin.user.search.post';
            $list_tab[] = 'admin.user_interim.search.post';
            $list_tab[] = 'admin.user.search.post';
            $list_tab[] = 'admin.user.interim';
            $list_tab[] = 'admin.user.export_csv';

            $list_tab[] = 'admin.mail_bulk';
            $list_tab[] = 'admin.mail_bulk.add';
            $list_tab[] = 'admin.mail_bulk.edit';
            $list_tab[] = 'admin.mail_bulk.store';
            $list_tab[] = 'admin.mail_bulk.stop';

            $list_tab[] = 'admin.mail_schedule';
            $list_tab[] = 'admin.mail_schedule.add';
            $list_tab[] = 'admin.mail_schedule.edit';
            $list_tab[] = 'admin.mail_schedule.store';
            $list_tab[] = 'admin.mail_schedule.stop';

            $list_tab[] = 'admin.user.search_login_history';
            $list_tab[] = 'admin.user.login_history';
            break;

        case 'payment';
            $list_tab[] = 'admin.payment';
            $list_tab[] = 'admin.deposit';
            $list_tab[] = 'admin.deposit.apply';
            $list_tab[] = 'admin.trans_gift';
            $list_tab[] = 'admin.trans_gift_bonus.add';
            break;

        case 'site';
            $list_tab[] = 'admin.entrance';
            $list_tab[] = 'admin.entrance.add';
            $list_tab[] = 'admin.entrance.edit';
            $list_tab[] = 'admin.entrance.store';
            $list_tab[] = 'admin.entrance.delete';
            $list_tab[] = 'admin.page';
            $list_tab[] = 'admin.page.add';
            $list_tab[] = 'admin.page.edit';
            $list_tab[] = 'admin.page.store';
            $list_tab[] = 'admin.page.delete';
            $list_tab[] = 'admin.point';
            $list_tab[] = 'admin.point.edit';
            $list_tab[] = 'admin.point.store';
            $list_tab[] = 'admin.point.delete';
            $list_tab[] = 'admin.venue';
            $list_tab[] = 'admin.venue.edit';
            $list_tab[] = 'admin.venue.store';
            $list_tab[] = 'admin.venue.delete';
            $list_tab[] = 'admin.user_stage';
            $list_tab[] = 'admin.user_stage.edit';
            $list_tab[] = 'admin.user_stage.store';
            $list_tab[] = 'admin.user_stage.delete';
            $list_tab[] = 'admin.media';
            $list_tab[] = 'admin.media.add';
            $list_tab[] = 'admin.media.edit';
            $list_tab[] = 'admin.media.store';
            $list_tab[] = 'admin.media.delete';
            break;

        case 'content';
            $list_tab[] = 'admin.blog';
            $list_tab[] = 'admin.blog.add';
            $list_tab[] = 'admin.blog.edit';
            $list_tab[] = 'admin.blog.store';
            $list_tab[] = 'admin.blog.review';
            $list_tab[] = 'admin.blog.delete';
            $list_tab[] = 'admin.gift';
            $list_tab[] = 'admin.gift';
            $list_tab[] = 'admin.gift.add';
            $list_tab[] = 'admin.gift.edit';
            $list_tab[] = 'admin.gift.store';
            $list_tab[] = 'admin.gift.delete';
            $list_tab[] = 'admin.result';
            $list_tab[] = 'admin.result.add';
            $list_tab[] = 'admin.result.edit';
            $list_tab[] = 'admin.result.store';
            $list_tab[] = 'admin.result.review';
            $list_tab[] = 'admin.result.delete';
            $list_tab[] = 'admin.edit_frontend';
            break;

        case 'campaign';
            $list_tab[] = 'admin.prediction';
            $list_tab[] = 'admin.prediction.add';
            $list_tab[] = 'admin.prediction.edit';
            $list_tab[] = 'admin.prediction.delete';
            $list_tab[] = 'admin.prediction.result';
            $list_tab[] = 'admin.prediction.store';
            $list_tab[] = 'admin.prediction.review';
            $list_tab[] = 'admin.prediction.type';
            $list_tab[] = 'admin.prediction_type.add';
            $list_tab[] = 'admin.prediction_type.edit';
            $list_tab[] = 'admin.prediction_type.delete';
            break;

        case 'mail';
            $list_tab[] = 'admin.mail_template';
            $list_tab[] = 'admin.mail_template.add';
            $list_tab[] = 'admin.mail_template.edit';
            $list_tab[] = 'admin.mail_template.store';
            $list_tab[] = 'admin.mail_template.delete';

            $list_tab[] = 'admin.mail_contact';
            $list_tab[] = 'admin.mail_contact.send';
            $list_tab[] = 'admin.mail_contact.admin_read.ajax';
            $list_tab[] = 'admin.mail_contact.delete';

            $list_tab[] = 'admin.mail_ban';
            $list_tab[] = 'admin.mail_ban.edit';
            
            $list_tab[] = 'admin.list.mail.contact';
            $list_tab[] = 'admin.list.mail.contact.ajax';
            break;

        case 'summary';
            $list_tab[] = 'admin.summary.payment';
            $list_tab[] = 'admin.summary.deposit';
            $list_tab[] = 'admin.summary.access';
            $list_tab[] = 'admin.summary.gift';
            $list_tab[] = 'admin.summary.mail_bulk';
            $list_tab[] = 'admin.summary.mail_schedule';
            $list_tab[] = 'admin.summary.media';
            $list_tab[] = 'admin.summary.media_code';
            $list_tab[] = 'admin.summary.billing';
            $list_tab[] = 'admin.summary.user_stage';
            $list_tab[] = 'admin.summary.entrance';
            $list_tab[] = 'admin.summary.entrance_detail';
            break;

        case 'management';
            $list_tab[] = 'admin.admin';
            $list_tab[] = 'admin.admin.add';
            $list_tab[] = 'admin.admin.edit';
            $list_tab[] = 'admin.admin.store';
            $list_tab[] = 'admin.admin.update';
            $list_tab[] = 'admin.admin.delete';
            $list_tab[] = 'admin.partner';
            $list_tab[] = 'admin.partner.add';
            $list_tab[] = 'admin.partner.edit';
            $list_tab[] = 'admin.partner.store';
            $list_tab[] = 'admin.partner.delete';
            break;

        case 'system';
            $list_tab[] = 'admin.mail_replace';
            $list_tab[] = 'admin.mail_replace.add';
            $list_tab[] = 'admin.mail_replace.edit';
            $list_tab[] = 'admin.mail_replace.store';
            $list_tab[] = 'admin.mail_replace.update';
            $list_tab[] = 'admin.mail_replace.delete';
            break;

        case 'order';
            break;
    }

    return in_array(Request::route()->getName(), $list_tab) ? '   active' : '';
}

function sortArrayByKey(&$array, $key, $string = false, $asc = true)
{
    if ($string) {
        usort($array, function ($a, $b) use (&$key, &$asc) {
            if ($asc) {
                return strcmp(strtolower($a{ $key}), strtolower($b{ $key}));
            } else {
                return strcmp(strtolower($b{$key}), strtolower($a{$key}));
            }

        });
    } else {
        usort($array, function ($a, $b) use (&$key, &$asc) {
            if ($a[$key] == $b{ $key}) {
                return 0;
            }
            if ($asc) {
                return ($a{$key} < $b{$key}) ? -1 : 1;
            } else {
                return ($a{$key} > $b{$key}) ? -1 : 1;
            }

        });
    }
}

// create random login id
function getRandomNumber($length)
{
    for ($i = 0; $i < $length; $i++) {
        if ($i == 0) {
            $code = str_pad(mt_rand(1, 9), 1, '0', STR_PAD_LEFT);
        } else {
            $code .= str_pad(mt_rand(0, 9), 1, '0', STR_PAD_LEFT);
        }

    }
    return $code;
}

function getUniqueCodeNumber($length, $table, $column)
{
    $code = getRandomNumber($length);

    while (true) {
        $check = DB::table($table)->where($column, $code)->first();

        if (!is_null($check)) {
            $code = getRandomNumber($length);
        } else {
            break;
        }
    }
    return $code;
}

/*
 * Create a random string
 */
function randomString($length = 6)
{
    $str = "";
    $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}

function getUniqueString($length, $table, $column)
{
    $code = randomString($length);

    while (true) {
        $check = DB::table($table)->where($column, $code)->first();

        if (!is_null($check)) {
            $code = randomString($length);
        } else {
            break;
        }
    }
    return $code;
}

function generatePassword($length = 20)
{
//  $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' .
    //    '0123456789`-=~!@#$%^&*()_+,./<>?;:[]{}\|';

    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' .
        '0123456789';

    $str = '';
    $max = strlen($chars) - 1;

    for ($i = 0; $i < $length; $i++) {
        $str .= $chars[random_int(0, $max)];
    }

    return $str;
}

// Type Mail template
function typeMailTemplateStr($type)
{
    switch ($type) {
        case MAIL_TEMPLATE_TYPE_REGISTER:
            $str_type = __("horserace::be_form.mail_template_type_register");
            break;

        case MAIL_TEMPLATE_TYPE_PAYMENT:
            $str_type = __("horserace::be_form.mail_template_type_payment");
            break;

        case MAIL_TEMPLATE_TYPE_DEPOSIT:
            $str_type = __("horserace::be_form.mail_template_type_deposit");
            break;

        case MAIL_TEMPLATE_TYPE_BULK:
            $str_type = __("horserace::be_form.mail_template_type_bulk");
            break;

        case MAIL_TEMPLATE_TYPE_SCHEDULE:
            $str_type = __("horserace::be_form.mail_template_type_schedule");
            break;

        case MAIL_TEMPLATE_TYPE_CONTACT:
            $str_type = __("horserace::be_form.mail_template_type_contact");
            break;

        case MAIL_TEMPLATE_TYPE_ORDER:
            $str_type = __("horserace::be_form.mail_template_type_order");
            break;

        case MAIL_TEMPLATE_TYPE_FORGET_PASSWORD:
            $str_type = __("horserace::be_form.mail_template_type_forget_password");
            break;
        
        case MAIL_TEMPLATE_TYPE_CHANGE_MAIL_PC:
            $str_type = __("horserace::be_form.mail_template_type_change_mail_pc");
            break;
        
        case MAIL_TEMPLATE_TYPE_CHANGE_MAIL_MOBILE:
            $str_type = __("horserace::be_form.mail_template_type_change_mail_mobile");
            break;
        default:
            $str_type = __("horserace::be_form.unset");
            break;
    }
    return $str_type;
}

// Type gift
function typeGiftStr($type)
{
    switch ($type) {
        case GIFT_TYPE_REGISTER:
            $str_type = __("horserace::be_form.gift_type_register");
            break;

        case GIFT_TYPE_PAYMENT:
            $str_type = __("horserace::be_form.gift_type_payment");
            break;

        case GIFT_TYPE_DEPOSIT:
            $str_type = __("horserace::be_form.gift_type_deposit");
            break;

        case GIFT_TYPE_PREDICTION:
            $str_type = __("horserace::be_form.gift_type_prediction");
            break;

        case GIFT_TYPE_EVENT:
            $str_type = __("horserace::be_form.gift_type_event");
            break;

        default:
            $str_type = __("horserace::be_form.unset");
            break;
    }
    return $str_type;
}

// Member level
function memberLevelStr($type)
{
    switch ($type) {
        case MEMBER_LEVEL_TRIAL:
            $str_type = __("horserace::be_form.member_level_trail");
            break;

        case MEMBER_LEVEL_GOLD:
            $str_type = __("horserace::be_form.member_level_gold");
            break;

        case MEMBER_LEVEL_DIAMOND:
            $str_type = __("horserace::be_form.member_level_diamond");
            break;

        case MEMBER_LEVEL_CRYSTAL:
            $str_type = __("horserace::be_form.member_level_crystal");
            break;

        case MEMBER_LEVEL_EXCEPT:
            $str_type = __("horserace::be_form.member_level_except");
            break;

        case MEMBER_SPECIAL:
            $str_type = __("horserace::be_form.member_special");
            break;

        default:
            $str_type = __("horserace::be_form.unset");
            break;
    }
    return $str_type;
}

// Mail schedule type
function mailScheduleTypeStr($type)
{
    switch ($type) {
        case MAIL_SCHEDULE_TYPE_RESERVE:
            $str_type = __("horserace::be_form.reserve_datetime");
            break;

        case MAIL_SCHEDULE_TYPE_WEEKLY:
            $str_type = __("horserace::be_form.weekly");
            break;

        case MAIL_SCHEDULE_TYPE_DAILY:
            $str_type = __("horserace::be_form.daily");
            break;

        default:
            $str_type = '';
            break;
    }
    return $str_type;
}

// Prediction type
function predictionTypeStr($type)
{
    switch ($type) {
        case PREDICTION_TYPE_TRIAL_PACK:
            $str_type = __("horserace::be_form.prediction_type_trial_pack");
            break;

        case PREDICTION_TYPE_OWNERS_SECRET:
            $str_type = __("horserace::be_form.prediction_type_owners_secret");
            break;

        case PREDICTION_TYPE_AGENT_EYE:
            $str_type = __("horserace::be_form.prediction_type_agent_eye");
            break;

        case PREDICTION_TYPE_RECEPTION_RACE:
            $str_type = __("horserace::be_form.prediction_type_reception_race");
            break;

        case PREDICTION_TYPE_THE_STALLION:
            $str_type = __("horserace::be_form.prediction_type_stallion");
            break;

        case PREDICTION_TYPE_GREAT_NINE:
            $str_type = __("horserace::be_form.prediction_type_great_nine");
            break;

        case PREDICTION_TYPE_ONLY_ONE:
            $str_type = __("horserace::be_form.prediction_type_only_one");
            break;

        default:
            $str_type = __("horserace::be_form.unset");
            break;
    }
    return $str_type;
}

// Ticket_type no
function ticketToStr($type)
{
    switch ($type) {
        case TICKET_TYPE_1:
            $str_type = __("horserace::be_form.ticket_type_1");
            break;

        case TICKET_TYPE_2:
            $str_type = __("horserace::be_form.ticket_type_2");
            break;

        case TICKET_TYPE_3:
            $str_type = __("horserace::be_form.ticket_type_3");
            break;

        default:
            // $str_type = __("horserace::be_form.unset");
            $str_type = " ";
            break;
    }
    return $str_type;
}

// dat comment -> course input manual not by select
// Course no
// function courseToStr($type)
// {
//     switch ($type) {
//         case COURSE_1ST:
//             $str_type = __("horserace::be_form.course_1st");
//             break;

//         case COURSE_2ND:
//             $str_type = __("horserace::be_form.course_2nd");
//             break;

//         case COURSE_3RD:
//             $str_type = __("horserace::be_form.course_3rd");
//             break;

//         case COURSE_4TH:
//             $str_type = __("horserace::be_form.course_4th");
//             break;

//         case COURSE_5TH:
//             $str_type = __("horserace::be_form.course_5th");
//             break;

//         default:
//             // $str_type = __("horserace::be_form.unset");
//             $str_type = " ";
//             break;
//     }
//     return $str_type;
// }

// Double no
function doubleToStr($type)
{
    switch ($type) {
        case DOUBLE_ON:
            $str_type = __("horserace::be_form.double_on");
            break;

        case DOUBLE_OFF:
            $str_type = __("horserace::be_form.double_off");
            break;

        default:
            // $str_type = __("horserace::be_form.unset");
            $str_type = " ";
            break;
    }
    return $str_type;
}

// Race no
function raceNoStr($type)
{
    switch ($type) {
        case RACE_NO_1:
            $str_type = __("horserace::be_form.race_no_1");
            break;

        case RACE_NO_2:
            $str_type = __("horserace::be_form.race_no_2");
            break;

        case RACE_NO_3:
            $str_type = __("horserace::be_form.race_no_3");
            break;

        case RACE_NO_4:
            $str_type = __("horserace::be_form.race_no_4");
            break;

        case RACE_NO_5:
            $str_type = __("horserace::be_form.race_no_5");
            break;

        case RACE_NO_6:
            $str_type = __("horserace::be_form.race_no_6");
            break;

        case RACE_NO_7:
            $str_type = __("horserace::be_form.race_no_7");
            break;

        case RACE_NO_8:
            $str_type = __("horserace::be_form.race_no_8");
            break;

        case RACE_NO_9:
            $str_type = __("horserace::be_form.race_no_9");
            break;

        case RACE_NO_10:
            $str_type = __("horserace::be_form.race_no_11");
            break;

        case RACE_NO_11:
            $str_type = __("horserace::be_form.race_no_11");
            break;

        case RACE_NO_12:
            $str_type = __("horserace::be_form.race_no_12");
            break;

        default:
            // $str_type = __("horserace::be_form.unset");
            $str_type = " ";
            break;
    }
    return $str_type;
}

// Race no image
function raceNoToImg($type)
{
    switch ($type) {
        case RACE_NO_1:
            $str_type = 'frontend/images/race/race01.svg';
            break;

        case RACE_NO_2:
            $str_type = 'frontend/images/race/race02.svg';
            break;

        case RACE_NO_3:
            $str_type = 'frontend/images/race/race03.svg';
            break;

        case RACE_NO_4:
            $str_type = 'frontend/images/race/race04.svg';
            break;

        case RACE_NO_5:
            $str_type = 'frontend/images/race/race05.svg';
            break;

        case RACE_NO_6:
            $str_type = 'frontend/images/race/race06.svg';
            break;

        case RACE_NO_7:
            $str_type = 'frontend/images/race/race07.svg';
            break;

        case RACE_NO_8:
            $str_type = 'frontend/images/race/race08.svg';
            break;

        case RACE_NO_9:
            $str_type = 'frontend/images/race/race09.svg';
            break;

        case RACE_NO_10:
            $str_type = 'frontend/images/race/race10.svg';
            break;

        case RACE_NO_11:
            $str_type = 'frontend/images/race/race11.svg';
            break;

        case RACE_NO_12:
            $str_type = 'frontend/images/race/race12.svg';
            break;

        default:
            // $str_type = __("horserace::be_form.unset");
            $str_type = " ";
            break;
    }
    return $str_type;
}

// prediction_status
function predictionStatusStr($type)
{
    switch ($type) {
        case PREDICTION_STATUS_PREPARE:
            $str_type = __("horserace::be_form.prediction_status_prepare");
            break;

        case PREDICTION_STATUS_OPEN:
            $str_type = __("horserace::be_form.prediction_status_open");
            break;

        case PREDICTION_STATUS_REMAIN:
            $str_type = __("horserace::be_form.prediction_status_remain");
            break;

        case PREDICTION_STATUS_DONE:
            $str_type = __("horserace::be_form.prediction_status_done");
            break;

        default:
            $str_type = __("horserace::be_form.unset");
            break;
    }
    return $str_type;
}

// Blog status
function blogStatusStr($type)
{
    switch ($type) {
        case BLOG_STATUS_0:
            $str_type = __("horserace::be_form.blog_status_0");
            break;

        case BLOG_STATUS_1:
            $str_type = __("horserace::be_form.blog_status_1");
            break;

        case BLOG_STATUS_2:
            $str_type = __("horserace::be_form.blog_status_2");
            break;

        case BLOG_STATUS_3:
            $str_type = __("horserace::be_form.blog_status_3");
            break;

        case BLOG_STATUS_4:
            $str_type = __("horserace::be_form.blog_status_4");
            break;
        case BLOG_STATUS_5:
            $str_type = __("horserace::be_form.blog_status_5");
            break;
        default:
            $str_type = __("horserace::be_form.unset");
            break;
    }
    return $str_type;
}

// Method deposit
function methodDepositStr($type)
{
    switch ($type) {
        case METHOD_BANK:
            $str_type = __("horserace::be_form.method_bank");
            break;

        case METHOD_CREDIT:
            $str_type = __("horserace::be_form.method_credit");
            break;

        default:
            $str_type = __("horserace::be_form.unset");
            break;
    }
    return $str_type;
}

// Status apply
function paymentStatusStr($type)
{
    switch ($type) {
        case NOT_APPLY:
            $str_type = __("horserace::be_form.payment_not_apply");
            break;

        case APPLY:
            $str_type = __("horserace::be_form.payment_apply");
            break;

        default:
            $str_type = __("horserace::be_form.unset");
            break;
    }
    return $str_type;
}

function listDayInMonth($year, $month)
{
    $list = array();
    for ($d = 1; $d <= 31; $d++) {
        $time = mktime(12, 0, 0, $month, $d, $year);
        if (date('m', $time) == $month) {
            $list[] = date('Y-m-d', $time);
        }

    }
    return $list;
}

function weeksInMonth($year, $month)
{
    $weeks_in_month = array();
    // Start of month
    $start = mktime(0, 0, 0, $month, 1, $year);
    // End of month
    $end = mktime(0, 0, 0, $month, date('t', $start), $year);
    // Start week
    $start_week = date('W', $start);
    // End week
    $end_week = date('W', $end);

    if ($end_week < $start_week) { // Month wraps
        //year has 52 weeks
        $weeksInYear = 52;
        //but if leap year, it has 53 weeks
        if ($year % 4 == 0) {
            $weeksInYear = 53;
        }
        $end_week = $weeksInYear + $end_week;
        $total_week = (($weeksInYear + $end_week) - $start_week) + 1;
    }

    $total_week = ((integer) $end_week - (integer) $start_week) + 1;

    $list_week = array();
    for ($i = (integer) $start_week; $i <= (integer) $end_week; $i++) {
        //Returns the date of monday in week
        if ($i < 10) {
            $i = "0" . $i;
        }
        $list_week[(integer) $i]['from'] = date("Y-m-d", strtotime("{$year}-W{$i}-1"));
        //Returns the date of sunday in week
        $list_week[(integer) $i]['to'] = date("Y-m-d", strtotime("{$year}-W{$i}-7"));
    }

    return $weeks_in_month = [
        'start_week' => (integer) $start_week,
        'end_week' => (integer) $end_week,
        'total_week' => $total_week,
        'list_week' => $list_week,
    ];
}

// Day
function dayToStr($type)
{
    switch ($type) {
        case SUNDAY:
            $str_type = __("horserace::be_form.sunday");
            break;

        case MONDAY:
            $str_type = __("horserace::be_form.monday");
            break;

        case TUESDAY:
            $str_type = __("horserace::be_form.tuesday");
            break;

        case WEDNESDAY:
            $str_type = __("horserace::be_form.wednesday");
            break;

        case THURSDAY:
            $str_type = __("horserace::be_form.thursday");
            break;

        case FRIDAY:
            $str_type = __("horserace::be_form.friday");
            break;

        case SATURDAY:
            $str_type = __("horserace::be_form.saturday");
            break;

        default:
            $str_type = __("horserace::be_form.unset");
            break;
    }
    return $str_type;
}

// background color prediction
function backgroundColorPre($type)
{
    switch ($type) {
        case PREDICTION_STATUS_PREPARE:
            $str_type = "bg-yarrow";
            break;

        case PREDICTION_STATUS_OPEN:
            $str_type = "bg-greenish";
            break;

        case PREDICTION_STATUS_REMAIN:
            $str_type = "bg-pink-glamour";
            break;

        case PREDICTION_STATUS_DONE:
            $str_type = "bc-clouds";
            break;

        default:
            $str_type = "bc-clouds";
            break;
    }
    return $str_type;
}

// Age
function ageToStr($type)
{

    switch ($type) {
        case AGE_USER_20:
            $str_type = __("horserace::be_form.age_20");
            break;

        case AGE_USER_30:
            $str_type = __("horserace::be_form.age_30");
            break;

        case AGE_USER_40:
            $str_type = __("horserace::be_form.age_40");
            break;

        case AGE_USER_50:
            $str_type = __("horserace::be_form.age_50");
            break;

        case AGE_USER_60:
            $str_type = __("horserace::be_form.age_60");
            break;

        case AGE_USER_70:
            $str_type = __("horserace::be_form.age_70");
            break;

        default:
            $str_type = 0;
            break;
    }
    return $str_type;
}

// mail_schedule_properties
function mailPropertiesStr($type)
{

    switch ($type) {
        case MAIL_SCHEDULE_PROPERTIES_ELAPSED:
            $str_type = __("horserace::be_form.mail_schedule_properties_elapsed");
            break;

        case MAIL_SCHEDULE_PROPERTIES_DESIGNATION:
            $str_type = __("horserace::be_form.mail_schedule_properties_designation");
            break;

        default:
            $str_type = '';
            break;
    }
    return $str_type;
}

// Mail schedule target
function mailScheduleTargetStr($type)
{
    switch ($type) {
        case MAIL_SCHEDULE_TARGET_REGISTER:
            $str_type = __("horserace::be_form.mail_schedule_target_register");
            break;

        case MAIL_SCHEDULE_TARGET_PAYMENT:
            $str_type = __("horserace::be_form.mail_schedule_target_payment");
            break;

        case MAIL_SCHEDULE_TARGET_DEPOSIT:
            $str_type = __("horserace::be_form.mail_schedule_target_deposit");
            break;

        case MAIL_SCHEDULE_TARGET_USER_INTERIM:
            $str_type = __("horserace::be_form.mail_schedule_user_interim");
            break;

        default:
            $str_type = '';
            break;
    }
    return $str_type;
}

// Add month
function addMonth($year, $month, $number_month)
{
    $datetime = $year . "-" . $month . "-" . "01";
    $effectiveDate = date('Y-m-d', strtotime("+" . $number_month . " months", strtotime($datetime)));

    $result = [
        "year" => date("Y", strtotime($effectiveDate)),
        "month" => date("m", strtotime($effectiveDate)),
    ];
    return $result;
}

// Sub month
function subMonth($year, $month, $number_month)
{
    $datetime = $year . "-" . $month . "-" . "01";
    $effectiveDate = date('Y-m-d', strtotime("-" . $number_month . " months", strtotime($datetime)));

    $result = [
        "year" => date("Y", strtotime($effectiveDate)),
        "month" => date("m", strtotime($effectiveDate)),
    ];
    return $result;
}

// Gender to string
function genderToStr($type)
{
    switch ($type) {
        case MALE:
            $str_type = __("horserace::be_form.male");
            break;

        case FEMALE:
            $str_type = __("horserace::be_form.female");
            break;

        default:
            $str_type = '';
            break;
    }
    return $str_type;
}

// tranfer status to string
function transferStatusToStr($type)
{
    switch ($type) {
        case "OK":
            $str_type = __("horserace::be_form.transfer_status_ok");
            break;

        case "TEST":
            $str_type = __("horserace::be_form.transfer_status_test");
            break;

        case "OVER":
            $str_type = __("horserace::be_form.transfer_status_over");
            break;

        case "LESS":
            $str_type = __("horserace::be_form.transfer_status_less");
            break;

        case "TIMEOUT":
            $str_type = __("horserace::be_form.transfer_status_timeout");
            break;

        default:
            $str_type = '';
            break;
    }
    return $str_type;
}

// deposit status to class
function depositToClass($item)
{
    if ($item->status == NOT_APPLY) {
        if($item->note == 'OVER' || $item->note == 'LESS'){
            $str_class = 'bg-danger';
        } else {
            $str_class = '';
        }
    } else {
        $str_class = 'bg-asbestos';
    }

    return $str_class;
}

// Check ip
function ipbetweenrange($needle, $start, $end)
{
    if ((ip2long($needle) >= ip2long($start)) && (ip2long($needle) <= ip2long($end))) {
        return true;
    }
    return false;
}

// Remove 2 Byte space
function remove2ByteSpace($string)
{
    $result = preg_replace('/　.*$/', '', $string);
    return $result;
}

function normalizaBase64($data)
{
    $spaces = substr_count($data, " ");
    if (($spaces / strlen($data)) < 0.05) {
        return base64_decode($data);
    }
    return $data;
}

function conditionToText($input)
{
    $arr_condition = json_decode($input, true);
    $arr_data = array();

    // Login id
    if (isset($arr_condition["login_id"]) && !is_null($arr_condition["login_id"])) {
        $arr_data["login_id"]["label"] = __("horserace::be_form.login_id");
        $arr_data["login_id"]["value"] = $arr_condition["login_id"];
    }

    // user_key
    if (isset($arr_condition["user_key"]) && !is_null($arr_condition["user_key"])) {
        $arr_data["user_key"]["label"] = __("horserace::be_form.user_key");
        $arr_data["user_key"]["value"] = $arr_condition["user_key"];
    }

    // point_min
    if (isset($arr_condition["point_min"]) && !is_null($arr_condition["point_min"])) {
        $arr_data["point_min"]["label"] = __("horserace::be_form.point_min");
        $arr_data["point_min"]["value"] = $arr_condition["point_min"];
    }

    // point_max
    if (isset($arr_condition["point_max"]) && !is_null($arr_condition["point_max"])) {
        $arr_data["point_max"]["label"] = __("horserace::be_form.point_max");
        $arr_data["point_max"]["value"] = $arr_condition["point_max"];
    }

    // nickname
    if (isset($arr_condition["nickname"]) && !is_null($arr_condition["nickname"])) {
        $arr_data["nickname"]["label"] = __("horserace::be_form.nickname");
        $arr_data["nickname"]["value"] = $arr_condition["nickname"];
    }

    // member_level
    if (isset($arr_condition["member_level"]) && !is_null($arr_condition["member_level"])) {
        $arr_data["member_level"]["label"] = __("horserace::be_form.member_level");
        $arr_data["member_level"]["value"] = memberLevelStr($arr_condition["member_level"]);
    }

    // deposit_total_amount_min
    if (isset($arr_condition["deposit_total_amount_min"]) && !is_null($arr_condition["deposit_total_amount_min"])) {
        $arr_data["deposit_total_amount_min"]["label"] = __("horserace::be_form.deposit_total_amount_min");
        $arr_data["deposit_total_amount_min"]["value"] = $arr_condition["deposit_total_amount_min"];
    }

    // deposit_total_amount_max
    if (isset($arr_condition["deposit_total_amount_max"]) && !is_null($arr_condition["deposit_total_amount_max"])) {
        $arr_data["deposit_total_amount_max"]["label"] = __("horserace::be_form.deposit_total_amount_max");
        $arr_data["deposit_total_amount_max"]["value"] = $arr_condition["deposit_total_amount_max"];
    }

    // age
    if (isset($arr_condition["age"]) && !is_null($arr_condition["age"])) {
        $arr_data["age"]["label"] = __("horserace::be_form.age");
        $arr_data["age"]["value"] = ageToStr($arr_condition["age"]);
    }

    // gender
    if (isset($arr_condition["gender"]) && !is_null($arr_condition["gender"])) {
        $arr_data["gender"]["label"] = __("horserace::be_form.gender");
        $str_gender = "";
        foreach ($arr_condition["gender"] as $item) {
            $str_gender .= genderToStr($item) . " ";
        }
        $arr_data["gender"]["value"] = trim($str_gender);
    }

    // deposit_total_number_min
    if (isset($arr_condition["deposit_total_number_min"]) && !is_null($arr_condition["deposit_total_number_min"])) {
        $arr_data["deposit_total_number_min"]["label"] = __("horserace::be_form.deposit_total_number_min");
        $arr_data["deposit_total_number_min"]["value"] = $arr_condition["deposit_total_number_min"];
    }

    // deposit_total_number_max
    if (isset($arr_condition["deposit_total_number_max"]) && !is_null($arr_condition["deposit_total_number_max"])) {
        $arr_data["deposit_total_number_max"]["label"] = __("horserace::be_form.deposit_total_number_max");
        $arr_data["deposit_total_number_max"]["value"] = $arr_condition["deposit_total_number_max"];
    }

    // mail_pc
    if (isset($arr_condition["mail_pc"]) && !is_null($arr_condition["mail_pc"])) {
        $arr_data["mail_pc"]["label"] = __("horserace::be_form.mail_pc");
        $arr_data["mail_pc"]["value"] = $arr_condition["mail_pc"];
    }

    // mail_mobile
    if (isset($arr_condition["mail_mobile"]) && !is_null($arr_condition["mail_mobile"])) {
        $arr_data["mail_mobile"]["label"] = __("horserace::be_form.mail_mobile");
        $arr_data["mail_mobile"]["value"] = $arr_condition["mail_mobile"];
    }

    // login_number_min
    if (isset($arr_condition["login_number_min"]) && !is_null($arr_condition["login_number_min"])) {
        $arr_data["login_number_min"]["label"] = __("horserace::be_form.login_number_min");
        $arr_data["login_number_min"]["value"] = $arr_condition["login_number_min"];
    }

    // login_number_max
    if (isset($arr_condition["login_number_max"]) && !is_null($arr_condition["login_number_max"])) {
        $arr_data["login_number_max"]["label"] = __("horserace::be_form.login_number_max");
        $arr_data["login_number_max"]["value"] = $arr_condition["login_number_max"];
    }

    // ip
    if (isset($arr_condition["ip"]) && !is_null($arr_condition["ip"])) {
        $arr_data["ip"]["label"] = __("horserace::be_form.ip");
        $arr_data["ip"]["value"] = $arr_condition["ip"];
    }

    // prediction_type
    if (isset($arr_condition["prediction_type"]) && !is_null($arr_condition["prediction_type"])) {
        $predictionTypeRepositories = new \Modules\Horserace\Repositories\PredictionTypeRepositories();
        $prediction_type = $predictionTypeRepositories->getPredictionType();
        $str_prediction_type = "";
        foreach ($prediction_type as $item) {
            if ($item->id == $arr_condition["prediction_type"]) {
                $str_prediction_type = $item->name;
                break;
            }
        }
        $arr_data["prediction_type"]["label"] = __("horserace::be_form.prediction_type");
        $arr_data["prediction_type"]["value"] = $str_prediction_type;
    }

    // register_time_start
    if (isset($arr_condition["register_time_start"]) && !is_null($arr_condition["register_time_start"])) {
        $arr_data["register_time_start"]["label"] = __("horserace::be_form.register_time_start");
        $arr_data["register_time_start"]["value"] = $arr_condition["register_time_start"];
    }

    // register_time_end
    if (isset($arr_condition["register_time_end"]) && !is_null($arr_condition["register_time_end"])) {
        $arr_data["register_time_end"]["label"] = __("horserace::be_form.register_time_end");
        $arr_data["register_time_end"]["value"] = $arr_condition["register_time_end"];
    }

    // media_code
    if (isset($arr_condition["media_code"]) && !is_null($arr_condition["media_code"])) {
        $arr_data["media_code"]["label"] = __("horserace::be_form.media_code");
        $arr_data["media_code"]["value"] = $arr_condition["media_code"];
    }

    // stop_mail
    if (isset($arr_condition["stop_mail"]) && !is_null($arr_condition["stop_mail"])) {
        $arr_data["stop_mail"]["label"] = __("horserace::be_form.stop_mail");
        switch ($arr_condition["stop_mail"]) {
            case STOP_MAIL_DISABLE:
                $arr_data["stop_mail"]["value"] = __("horserace::be_form.stop_mail_disable");
                break;

            case STOP_MAIL_ENABLE:
                $arr_data["stop_mail"]["value"] = __("horserace::be_form.stop_mail_enable");
                break;
        }

    }

    // entrance_id
    if (isset($arr_condition["entrance_id"]) && !is_null($arr_condition["entrance_id"])) {
        $entranceRepositories = new \Modules\Horserace\Repositories\EntranceRepositories();
        $entrance = $entranceRepositories->getListEntrance();
        $str_entrance = "";
        foreach ($entrance as $item) {
            if ($item->id == $arr_condition["entrance_id"]) {
                $str_entrance = $item->name;
                break;
            }
        }
        $arr_data["entrance_id"]["label"] = __("horserace::be_form.entrance");
        $arr_data["entrance_id"]["value"] = $str_entrance;
    }

    // user_stage_id
    if (isset($arr_condition["user_stage_id"]) && !is_null($arr_condition["user_stage_id"])) {
        $userStageRepositories = new \Modules\Horserace\Repositories\UserStageRepositories();
        $user_stage = $userStageRepositories->getListUserStage();
        $str_user_stage = "";
        foreach ($user_stage as $item) {
            if (isset($arr_condition["user_stage_id"][$item->id])) {
                $str_user_stage .= $item->name . ", ";
            }
        }

        $arr_data["user_stage"]["label"] = __("horserace::be_form.user_stage");

        if (isset($arr_condition["specify_stage"]) && !is_null($arr_condition["specify_stage"])) {
            switch ($arr_condition["specify_stage"]) {
                case USER_STAGE_MATCH:
                    $arr_data["user_stage"]["label"] .= "[" . __("horserace::be_form.user_stage_match") . "]";
                    break;

                case USER_STAGE_EXCLUSION:
                    $arr_data["user_stage"]["label"] .= "[" . __("horserace::be_form.user_stage_exclusion") . "]";
                    break;
            }
        }

        $arr_data["user_stage"]["value"] = trim($str_user_stage);
    }

    // first_deposit_time_start
    if (isset($arr_condition["first_deposit_time_start"]) && !is_null($arr_condition["first_deposit_time_start"])) {
        $arr_data["first_deposit_time_start"]["label"] = __("horserace::be_form.first_deposit_time_start");
        $arr_data["first_deposit_time_start"]["value"] = $arr_condition["register_time_end"];
    }

    // first_deposit_time_end
    if (isset($arr_condition["first_deposit_time_end"]) && !is_null($arr_condition["first_deposit_time_end"])) {
        $arr_data["first_deposit_time_end"]["label"] = __("horserace::be_form.first_deposit_time_end");
        $arr_data["first_deposit_time_end"]["value"] = $arr_condition["register_time_end"];
    }

    // last_deposit_time_start
    if (isset($arr_condition["last_deposit_time_start"]) && !is_null($arr_condition["last_deposit_time_start"])) {
        $arr_data["last_deposit_time_start"]["label"] = __("horserace::be_form.last_deposit_time_start");
        $arr_data["last_deposit_time_start"]["value"] = $arr_condition["register_time_end"];
    }

    // last_deposit_time_end
    if (isset($arr_condition["last_deposit_time_end"]) && !is_null($arr_condition["last_deposit_time_end"])) {
        $arr_data["last_deposit_time_end"]["label"] = __("horserace::be_form.last_deposit_time_end");
        $arr_data["last_deposit_time_end"]["value"] = $arr_condition["register_time_end"];
    }

    // first_payment_time_start
    if (isset($arr_condition["first_payment_time_start"]) && !is_null($arr_condition["first_payment_time_start"])) {
        $arr_data["first_payment_time_start"]["label"] = __("horserace::be_form.first_payment_time_start");
        $arr_data["first_payment_time_start"]["value"] = $arr_condition["register_time_end"];
    }

    // first_payment_time_end
    if (isset($arr_condition["first_payment_time_end"]) && !is_null($arr_condition["first_payment_time_end"])) {
        $arr_data["first_payment_time_end"]["label"] = __("horserace::be_form.first_payment_time_end");
        $arr_data["first_payment_time_end"]["value"] = $arr_condition["register_time_end"];
    }

    // last_payment_time_start
    if (isset($arr_condition["last_payment_time_start"]) && !is_null($arr_condition["last_payment_time_start"])) {
        $arr_data["last_payment_time_start"]["label"] = __("horserace::be_form.last_payment_time_start");
        $arr_data["last_payment_time_start"]["value"] = $arr_condition["register_time_end"];
    }

    // last_payment_time_end
    if (isset($arr_condition["last_payment_time_end"]) && !is_null($arr_condition["last_payment_time_end"])) {
        $arr_data["last_payment_time_end"]["label"] = __("horserace::be_form.last_payment_time_end");
        $arr_data["last_payment_time_end"]["value"] = $arr_condition["register_time_end"];
    }

    // last_login_time_start
    if (isset($arr_condition["last_login_time_start"]) && !is_null($arr_condition["last_login_time_start"])) {
        $arr_data["last_login_time_start"]["label"] = __("horserace::be_form.last_login_time_start");
        $arr_data["last_login_time_start"]["value"] = $arr_condition["register_time_end"];
    }

    // last_login_time_start
    if (isset($arr_condition["last_login_time_end"]) && !is_null($arr_condition["last_login_time_end"])) {
        $arr_data["last_login_time_end"]["label"] = __("horserace::be_form.last_login_time_end");
        $arr_data["last_login_time_end"]["value"] = $arr_condition["register_time_end"];
    }

    return $arr_data;
}

function replaceDayOfWeekJa($date_str)
{
    $result = str_replace('Monday', '月', $date_str);
    $result = str_replace('Tuesday', '火', $result);
    $result = str_replace('Wednesday', '水', $result);
    $result = str_replace('Thursday', '木', $result);
    $result = str_replace('Friday', '金', $result);
    $result = str_replace('Saturday', '土', $result);
    $result = str_replace('Sunday', '日', $result);

    return $result;
}
function DayOfWeekToJa($date_str)
{
    $day_of_week=['日','月','火','水','木','金','土'];
    return $day_of_week[date('w',$date_str)];

}

function replaceStringEmail($mail)
{
    $str = $mail;
    if(strpos($str, '@') !== false){
        $data=explode('@',$str);
        $leng = strlen($data[0]);
        $lengfor = $leng-3;
        $tr = '';
        for ($i = 0; $i < $lengfor; $i++) {
        $tr .= '*';
        }
        $str_first  = substr($data[0],0,3);
        $str_second = $tr;
        $str_third = $data[1];
        $result= $str_first.$str_second.'@'.$str_third;
        return $result;
    }else{
        return $str; 
    }
}