<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class ValidateNewTaskInputsService
{

    public function validate(array $inputs): bool
    {
        $customMessages = [
            'type.in' => 'The task type you provided is not supported. You can only use shopping or work.'
        ];

        $rules = [
            'title' => 'required',
            'priority' => 'integer',
            'type' => 'in:work,shopping',
        ];

        $validator = Validator::make($inputs, $rules, $customMessages);

        if ($validator->fails())
            throw new \InvalidArgumentException(implode(', ', $validator->errors()->all()));

        return true;
    }

}
