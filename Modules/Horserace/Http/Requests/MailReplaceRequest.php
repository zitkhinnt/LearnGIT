<?php

namespace Modules\Horserace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailReplaceRequest extends FormRequest
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
//      'type' => 'required',
      'source' => 'required',
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
      'name.required' => __("horserace::be_msg.mail_replace_name_required"),
      'type.required' => __("horserace::be_msg.mail_replace_type_required"),
      'source.required' => __("horserace::be_msg.mail_replace_source_required"),
    ];
  }
}
