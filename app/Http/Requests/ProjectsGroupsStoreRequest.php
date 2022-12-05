<?php

namespace App\Http\Requests;

use App\Models\GroupsProjects;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProjectsGroupsStoreRequest extends FormRequest
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
            case 'DELETE':
            {
                return [
                    'id' => 'required|exists:groups_projects,id'
                ];
            }
            case 'POST':
            {
                return [
                    'name' => [
                        'required',
                        'min:3',
                        'max:30',
                        // уникальное название группы для пользователя
                        function ($attribute, $value, $fail) {
                            if (GroupsProjects::where('user_id', Auth::id())->where('name', $value)->exists()) {
                                $fail('Название группы существует');
                            }
                        },
                        // правило меньше 10 групп проектов на пользователя
                        function ($attribute, $value, $fail) {
                            if (GroupsProjects::where('user_id', Auth::id())->count() >= 10) {
                                $fail('Не больше 10 групп');
                            }
                        },
                        // TODO сделать настройку для админа по количеству групп на пользователя, может быть в зависимости от тарифа
                    ],
                    'user_id' => 'required|min:1|max:30',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'id' => 'required|exists:groups_projects,id',
                    'name'=> 'required|min:3'
                ];
            }
            default:
                break;
        }
    }
}
