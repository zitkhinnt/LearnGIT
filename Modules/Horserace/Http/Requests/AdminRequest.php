<?php

namespace Modules\Horserace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'name' => 'required',
      'email' => 'required | unique:admins,email,'.$this->get('id'), 
      'login_id' => 'required | unique:admins,login_id,'.$this->get('id'),       
      'password' => 'required'
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
      'name.required' => __("horserace::be_msg.name_required"),
      'email.required' => __("horserace::be_msg.email_required"),
      'email.email' => __("horserace::be_msg.email_format"),
      'email.unique' => __("horserace::be_msg.email_unique"),
      'login_id.required' => __("horserace::be_msg.login_id_required"),
      'login_id.unique' => __("horserace::be_msg.login_id_unique"),
      'password.required' => __("horserace::be_msg.password_required")
    ];
  }
}
