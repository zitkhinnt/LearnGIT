<?php

namespace Modules\Horserace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
      'code' => 'required|alpha_dash|unique:page,code,' . $this->get('id'),
      'link' => 'required',
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
      'name.required' => __("horserace::be_msg.page_name_required"),
      'code.required' => __("horserace::be_msg.page_code_required"),
      'code.alpha_dash' => __("horserace::be_msg.page_code_alpha_dash"),
      'code.unique' => __("horserace::be_msg.page_code_unique"),
      'link.required' => __("horserace::be_msg.page_link_required"),
      'source.required' => __("horserace::be_msg.page_source_required")
    ];
  }
}
