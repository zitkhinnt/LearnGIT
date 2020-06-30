<?php
/**
 * Date 2018-09-10
 */

namespace Modules\Horserace\Repositories;

use DB;
use Modules\Horserace\Entities\MailBulkDetail;
use Modules\Horserace\Entities\MailBulkDone;
use Modules\Horserace\Entities\MailContact;
use Modules\Horserace\Entities\MailDepositDetail;
use Modules\Horserace\Entities\MailGiftDetail;
use Modules\Horserace\Entities\MailInterimDetail;
use Modules\Horserace\Entities\MailPaymentDetail;
use Modules\Horserace\Entities\MailPredictionOpenDetail;
use Modules\Horserace\Entities\MailPredictionResultDetail;
use Modules\Horserace\Entities\MailRegisterDetail;
use Modules\Horserace\Entities\MailReplace;
use Modules\Horserace\Entities\MailScheduleDetail;
use Modules\Horserace\Entities\MailScheduleDone;


class MailRepositories
{
  public function mailbox($user_id, $input)
  {
    $input['page'] = isset($input['page']) ? $input['page'] : 1;

    // Get list mail
    $mailbox = $this->getMailBoxByUserId($user_id, PAGINATE_MAIL_BOX);
    // Check page
    if ($input['page'] != 1) {
      $mailbox['currentPage'] = (int)$input['page'];
    }
    $data['mailbox'] = $mailbox;
    $data['input'] = $input;

    return $data;
  }

  public function getMailBoxByUserId($user_id, $paginate)
  {
    $obj_mail_contact = new MailContact();
    $obj_mail_bulk_detail = new MailBulkDetail();
    $obj_mail_schedule_detail = new MailScheduleDetail();
    $obj_mail_payment_detail = new MailPaymentDetail();
    $obj_mail_deposit_detail = new MailDepositDetail();
    $obj_mail_gift_detail = new MailGiftDetail();
    $obj_mail_pre_open_detail = new MailPredictionOpenDetail();
    $obj_mail_pre_result_detail = new MailPredictionResultDetail();
    $obj_mail_register_detail = new MailRegisterDetail();
    $obj_mail_interim_detail = new MailInterimDetail();

    // Mail contact
    $mail_contact = $obj_mail_contact->getMailContactByUserId($user_id);
    foreach ($mail_contact as $item) {
      $item->mail_type = MAIL_CONTACT;
      $result['item'][] = (array)$item;
    }

    // Mail bulk
    $mail_bulk = $obj_mail_bulk_detail->getMailBulkDetailByUserId($user_id);
    foreach ($mail_bulk as $item) {
      $item->mail_type = MAIL_BULK;
      $result['item'][] = (array)$item;
    }

    // Mail schedule
    $mail_schedule = $obj_mail_schedule_detail->getMailScheduleDetailByUserId($user_id);
    foreach ($mail_schedule as $item) {
      $item->mail_type = MAIL_SCHEDULE;
      $result['item'][] = (array)$item;
    }

    // Mail payment
    $mail_payment = $obj_mail_payment_detail->getMailPaymentDetailByUserId($user_id);
    foreach ($mail_payment as $item) {
      $item->mail_type = MAIL_PAYMENT;
      $result['item'][] = (array)$item;
    }

    // Mail deposit
    $mail_deposit = $obj_mail_deposit_detail->getMailDepositDetailByUserId($user_id);
    foreach ($mail_deposit as $item) {
      $item->mail_type = MAIL_DEPOSIT;
      $result['item'][] = (array)$item;
    }

    // Mail gift
    $mail_gift = $obj_mail_gift_detail->getMailGiftDetailByUserId($user_id);
    foreach ($mail_gift as $item) {
      $item->mail_type = MAIL_GIFT;
      $result['item'][] = (array)$item;
    }

    // Mail prediction open
    $mail_pre_open = $obj_mail_pre_open_detail->getMailPredictionOpenDetailByUserId($user_id);
    foreach ($mail_pre_open as $item) {
      $item->mail_type = MAIL_PREDICTION_OPEN;
      $result['item'][] = (array)$item;
    }

    // Mail prediction result
    $mail_pre_result = $obj_mail_pre_result_detail->getMailPredictionResultDetailByUserId($user_id);
    foreach ($mail_pre_result as $item) {
      $item->mail_type = MAIL_PREDICTION_RESULT;
      $result['item'][] = (array)$item;
    }

    // Mail register
    $mail_register = $obj_mail_register_detail->getMailRegisterDetailByUserId($user_id);
    foreach ($mail_register as $item) {
      $item->mail_type = MAIL_REGISTER;
      $result['item'][] = (array)$item;
    }

    // Mail interim
    $mail_interim = $obj_mail_interim_detail->getMailInterimDetailByUserId($user_id);
    foreach ($mail_interim as $item) {
      $item->mail_type = MAIL_INTERIM;
      $result['item'][] = (array)$item;
    }

    if (isset($result['item'])) {
      sortArrayByKey($result['item'], 'created_at', true, false);
    }

    $result['total'] = isset($result['item']) ? count($result['item']) : 0;
    $result['perPage'] = $paginate;
    $result['lastPage'] = (int)ceil($result['total'] / $result['perPage']);
    $result['currentPage'] = 1;

    return $result;
  }

  public function getMailInfo($type, $mail_id, $user_id)
  {
    $mail = null;
    $obj_mail_contact = new MailContact();
    $obj_mail_bulk_detail = new MailBulkDetail();
    $obj_mail_schedule_detail = new MailScheduleDetail();
    $obj_mail_payment_detail = new MailPaymentDetail();
    $obj_mail_deposit_detail = new MailDepositDetail();
    $obj_mail_gift_detail = new MailGiftDetail();
    $obj_mail_pre_open_detail = new MailPredictionOpenDetail();
    $obj_mail_pre_result_detail = new MailPredictionResultDetail();
    $obj_mail_register_detail = new MailRegisterDetail();
    $obj_mail_interim_detail = new MailInterimDetail();
    $obj_mail_bulk_done = new MailBulkDone();
    $obj_mail_schedule_done = new MailScheduleDone();

    // get mail
    switch ($type) {
      case MAIL_CONTACT:
        $mail = $obj_mail_contact->getMailContactByIdUser($user_id, $mail_id);
        $obj_mail_contact->changeMailContactUserReadAt($user_id, $mail_id);
        break;

      case MAIL_BULK:
        $mail = $obj_mail_bulk_detail->getMailBulkDetailByIdUser($user_id, $mail_id);
        if (is_null($mail->read_at)) {
          $obj_mail_bulk_done->addNumberReadByMailBulkId($mail->mail_bulk_id);
        }
        $obj_mail_bulk_detail->changeMailBulkReadAt($user_id, $mail_id);
        break;

      case MAIL_SCHEDULE:
        $mail = $obj_mail_schedule_detail->getMailScheduleDetailByIdUser($user_id, $mail_id);
        if (is_null($mail->read_at)) {
          $obj_mail_schedule_done->addNumberReadByMailScheduleId($mail_id);
        }
        $obj_mail_schedule_detail->changeMailScheduleReadAt($user_id, $mail_id);
        break;

      case MAIL_PAYMENT:
        $mail = $obj_mail_payment_detail->getMailPaymentDetailByIdUser($user_id, $mail_id);
        $obj_mail_payment_detail->changeMailPaymentReadAt($user_id, $mail_id);
        break;

      case MAIL_DEPOSIT:
        $mail = $obj_mail_deposit_detail->getMailDepositDetailByIdUser($user_id, $mail_id);
        $obj_mail_deposit_detail->changeMailDepositReadAt($user_id, $mail_id);
        break;

      case MAIL_GIFT:
        $mail = $obj_mail_gift_detail->getMailGiftDetailByIdUser($user_id, $mail_id);
        $obj_mail_gift_detail->changeMailGiftReadAt($user_id, $mail_id);
        break;

      case MAIL_PREDICTION_OPEN:
        $mail = $obj_mail_pre_open_detail->getMailPredictionOpenDetailByIdUser($user_id, $mail_id);
        $obj_mail_pre_open_detail->changeMailPredictionOpenReadAt($user_id, $mail_id);
        break;

      case MAIL_PREDICTION_RESULT:
        $mail = $obj_mail_pre_result_detail->getMailPredictionResultDetailByIdUser($user_id, $mail_id);
        $obj_mail_pre_result_detail->changeMailPredictionResultReadAt($user_id, $mail_id);
        break;

      case MAIL_REGISTER:
        $mail = $obj_mail_register_detail->getMailRegisterDetailByIdUser($user_id, $mail_id);
        $obj_mail_register_detail->changeMailRegisterReadAt($user_id, $mail_id);
        break;

      case MAIL_INTERIM:
        $mail = $obj_mail_interim_detail->getMailInterimDetailByIdUser($user_id, $mail_id);
        $obj_mail_interim_detail->changeMailInterimReadAt($user_id, $mail_id);
        break;

      default:
        break;
    }

    return $mail;
  }

  public function feDeletedMail($user_id, $input)
  {
    if (isset($input["mail_delete"])) {
      $obj_mail_contact = new MailContact();
      $obj_mail_bulk_detail = new MailBulkDetail();
      $obj_mail_schedule_detail = new MailScheduleDetail();
      $obj_mail_payment_detail = new MailPaymentDetail();
      $obj_mail_deposit_detail = new MailDepositDetail();
      $obj_mail_gift_detail = new MailGiftDetail();
      $obj_mail_pre_open_detail = new MailPredictionOpenDetail();
      $obj_mail_pre_result_detail = new MailPredictionResultDetail();
      $obj_mail_register_detail = new MailRegisterDetail();
      $obj_mail_interim_detail = new MailInterimDetail();

      foreach ($input["mail_delete"] as $key => $mail_id) {
        $mail_type = $input["mail_type"]["$key"];

        switch ($mail_type) {
          case MAIL_CONTACT:
            $obj_mail_contact->deleteMailContactUser($user_id, $mail_id);
            break;

          case MAIL_BULK:
            $obj_mail_bulk_detail->deleteMailBulkDetailUser($user_id, $mail_id);
            break;

          case MAIL_SCHEDULE:
            $obj_mail_schedule_detail->deleteMailScheduleDetailUser($user_id, $mail_id);
            break;

          case MAIL_PAYMENT:
            $obj_mail_payment_detail->deleteMailPaymentDetailUser($user_id, $mail_id);
            break;

          case MAIL_DEPOSIT:
            $obj_mail_deposit_detail->deleteMailDepositDetailUser($user_id, $mail_id);
            break;

          case MAIL_GIFT:
            $obj_mail_gift_detail->deleteMailGiftDetailUser($user_id, $mail_id);
            break;

          case MAIL_PREDICTION_OPEN:
            $obj_mail_pre_open_detail->deleteMailPredictionOpenDetailUser($user_id, $mail_id);
            break;

          case MAIL_PREDICTION_RESULT:
            $obj_mail_pre_result_detail->deleteMailPredictionResultDetailUser($user_id, $mail_id);
            break;

          case MAIL_REGISTER:
            $obj_mail_register_detail->deleteMailRegisterDetailUser($user_id, $mail_id);
            break;

          case MAIL_INTERIM:
            $obj_mail_interim_detail->deleteMailInterimDetailUser($user_id, $mail_id);
            break;

          default:
            break;
        }

      }
    }

    $result = [
      "status" => "success",
      "message" => __("horserace::be_msg.delete_mail_success"),
    ];

    return $result;
  }
}