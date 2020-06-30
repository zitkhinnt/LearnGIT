<?php

namespace Modules\Horserace\Http\Requests\frontend;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
  protected $redirect = "/#a02";

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      // 'email' => 'required|',
      'email' => [
        'required',
        function ($attribute, $value, $fail) {
          if (preg_match('/^[a-zA-Z0-9\.\-\+\_]+@[a-zA-Z0-9]+\.[a-zA-Z0-9\.]+$/', $value) == false) {
            return $fail(__("horserace::be_msg.email_wrong_format"));
          }
        },
      ],
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
      'email.required' => __("horserace::be_msg.email_required"),
      'email.email' => __("horserace::be_msg.email_wrong_format"),
    ];
  }
}
