<?php

namespace Modules\Horserace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnerRequest extends FormRequest
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
      'media_code' => 'required| unique:admins,media_code,' . $this->get('id'),
      'login_id' => 'required | unique:admins,login_id,' . $this->get('id'),
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
      'media_code.required' => __("horserace::be_msg.media_code_required"),
      'media_code.unique' => __("horserace::be_msg.media_code_unique"),
      'login_id.required' => __("horserace::be_msg.login_id_required"),
      'login_id.unique' => __("horserace::be_msg.login_id_unique"),
      'password.required' => __("horserace::be_msg.password_required")
    ];
  }
}
