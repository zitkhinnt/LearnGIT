<?php

namespace Modules\Horserace\Http\Requests\frontend;

use Illuminate\Foundation\Http\FormRequest;

class ChangeMailMobileUserRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'mail_mobile'    => 'required|email',
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

  public function messages () {
    return [
      'mail_mobile.required' => __("horserace::be_msg.mail_mobile_required"),
      'mail_mobile.email' => __("horserace::be_msg.mail_mobile_email"),
    ];
  }
}
