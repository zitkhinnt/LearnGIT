<?php

namespace Modules\Horserace\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'title' => 'required',
      'public_at' => 'required|date|date_format:Y-m-d H:i:s',
      'public_end' => 'required|date|date_format:Y-m-d H:i:s|after_or_equal:public_at',
      'content' => 'required',
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
      'title.required' => __("horserace::be_msg.blog_title_required"),
      'content.required' => __("horserace::be_msg.blog_content_required"),
      'public_at.required' => __("horserace::be_msg.public_at_required"),
      'public_end.required' => __("horserace::be_msg.public_end_required"),
      'public_end.after_or_equal' => __("horserace::be_msg.public_end_after_or_equal"),
    ];
  }
}
