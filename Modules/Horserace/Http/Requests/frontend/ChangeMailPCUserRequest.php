<?php

namespace Modules\Horserace\Http\Requests\frontend;

use Illuminate\Foundation\Http\FormRequest;

class ChangeMailPCUserRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'mail_pc'    => 'required|email',
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
      'mail_pc.required' => __("horserace::be_msg.mail_pc_required"),
      'mail_pc.email' => __("horserace::be_msg.mail_pc_email"),
    ];
  }
}
