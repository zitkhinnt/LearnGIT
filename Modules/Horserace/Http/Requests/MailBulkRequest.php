<?php

namespace Modules\Horserace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailBulkRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'mail_from_address' => 'required|email',
      'mail_from_name' => 'required',
      'mail_title' => 'required',
      'reserve_datetime' => 'required',
    ];
  }

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  public function messages()
  {
    return [
      'mail_from_address.required' => __("horserace::be_msg.mail_from_address_required"),
      'mail_from_address.email' => __("horserace::be_msg.mail_from_address_format"),
      'mail_from_name.required' => __("horserace::be_msg.mail_from_name_required"),
      'mail_title.required' => __("horserace::be_msg.mail_title_required"),
      'mail_body.required' => __("horserace::be_msg.mail_body_required"),
      'reserve_datetime.required' => __("horserace::be_msg.reserve_datetime_required"),
    ];
  }
}
