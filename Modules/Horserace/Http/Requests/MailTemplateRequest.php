<?php

namespace Modules\Horserace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailTemplateRequest extends FormRequest
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
      'mail_from_address' => 'required',
      'mail_from_name' => 'required',
      'type' => 'required',
      'mail_title' => 'required',
      'mail_body' => 'required',
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
      'name.required' => __("horserace::be_msg.name_mail_template_required"),
      'mail_from_address.required' => __("horserace::be_msg.mail_from_address_required"),
      'mail_from_name.required' => __("horserace::be_msg.mail_from_name_required"),
      'type.required' => __("horserace::be_msg.type_mail_template_required"),
      'mail_title.required' => __("horserace::be_msg.mail_title_required"),
      'mail_body.required' => __("horserace::be_msg.mail_body_required"),
    ];
  }
}
