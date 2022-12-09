<?php

namespace App\Http\Requests;

use App\Models\GroupsProjectsModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class projectRequest extends FormRequest
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
                    'id' => 'required|exists:projects,id'
                ];
            }
            case 'POST':
            {
                return [
                    'name'=> 'required|min:3',
                    'user_id' => 'required|min:1|max:30',
                    'client_id' => 'required|min:1|max:30',
                    'client_secret' => 'required|min:1|max:50',
                ];
            }
            default:
                break;
        }
    }
}
