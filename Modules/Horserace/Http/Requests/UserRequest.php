<?php

namespace Modules\Horserace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'login_id' => 'required',
      'user_key' => 'required',
      // 'nickname' => 'required',
      'password' => 'required',
      // 'mail_mobile' => 'email',
      'mail_pc' => 'required|email'
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
      'login_id.required' => __("horserace::be_msg.login_id_required"),
      'user_key.required' => __("horserace::be_msg.user_key_required"),
      'nickname.required' => __("horserace::be_msg.nickname_required"),
      'password.required' => __("horserace::be_msg.password_required"),
      'mail_mobile.email' => __("horserace::be_msg.mail_mobile_email"),
      'mail_pc.required' => __("horserace::be_msg.mail_pc_required"),
      'mail_pc.email' => __("horserace::be_msg.mail_pc_email"),
    ];
  }
}
