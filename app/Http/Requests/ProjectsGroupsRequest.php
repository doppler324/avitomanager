<?php

namespace App\Http\Requests;

use App\Models\GroupsProjects;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Rules\UpTo10;

class ProjectsGroupsRequest extends FormRequest
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
        return [
            'name' => [
                'required',
                'min:3',
                'max:30',
                'unique:groups_projects',
                // правило меньше 10 групп проектов на пользователя
                // TODO сделать настройку для админа по количеству групп на пользователя, может быть в зависимости от тарифа
                new UpTo10
            ],
            'user_id' => 'required|min:1|max:30',

        ];
    }

    /**
     * Получить сообщения об ошибках для определенных правил валидации.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.unique' => 'Такая группа уже есть'
        ];
    }
}
