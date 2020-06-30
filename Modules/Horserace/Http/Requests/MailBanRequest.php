<?php

namespace Modules\Horserace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailBanRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'mail' => 'required|regex:/[\@]+/',
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
      'mail.required' => __("horserace::be_msg.mail_block_mail_required"),
      'mail.regex' => __("horserace::be_msg.not_format_mail"),
    ];
  }
}
