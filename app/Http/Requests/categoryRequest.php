<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class categoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
            {
                return [
                    'id' => 'required|exists:categories,id'
                ];
            }
            case 'POST':
            {
                return [
                    'name'=> 'required|min:3',
                    'parent_category_id' => 'required|min:1|max:30',
                    'depth_level' => 'required|min:1|max:10',
                ];
            }
            default:
                break;
        }
    }
}
