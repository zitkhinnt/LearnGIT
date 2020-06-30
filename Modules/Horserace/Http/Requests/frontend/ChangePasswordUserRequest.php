<?php

namespace Modules\Horserace\Http\Requests\frontend;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordUserRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'password'    => 'required',
      'password_confirm'    => 'same:password',
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
      'password.required' => __("horserace::be_msg.password-required"),
      'password_confirm.same' => __("horserace::be_msg.password_confirm_same"),
    ];
  }
}
