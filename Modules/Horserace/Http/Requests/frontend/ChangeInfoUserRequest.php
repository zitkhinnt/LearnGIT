<?php

namespace Modules\Horserace\Http\Requests\frontend;

use Illuminate\Foundation\Http\FormRequest;

class ChangeInfoUserRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      //'nickname'    => 'required',
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
      'nickname.required'       => __("horserace::be_msg.nickname-required"),
    ];
  }
}
