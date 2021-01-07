<?php

namespace App\Http\Requests\Thread;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ThreadStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['required', 'numeric', 'exists:users,id'],
            'category_id' => ['required', 'numeric', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['required', 'string'],
            'body' => ['required']
        ];
    }

    /**
     * @return array|void
     */
    public function validationData()
    {
        $this->request->add([
            'user_id' => auth()->id(),
            'slug' => Str::slug($this->request->get('title')),
        ]);
        return $this->all();
    }
}
