<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class adsRequest extends FormRequest
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
                    'id' => 'exists:ads,id',
                    '$project_id' => 'exists:projects,id'
                ];
            }
            case 'POST':
            {
                return [
                    'title' => 'required|min:3',
                    'user_id' => 'required|min:1',
                    'category_id' => 'required|min:1',
                    'project_id' => 'required|min:1',
                ];
            }
            default:
                break;
        }
    }
}
