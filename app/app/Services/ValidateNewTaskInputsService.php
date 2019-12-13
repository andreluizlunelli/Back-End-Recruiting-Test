<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class ValidateNewTaskInputsService
{

    /**
     * @param array $inputs
     *
     * @return bool
     *
     * @throws \InvalidArgumentException
     */
    public function validate(array $inputs): bool
    {
        if (empty($inputs))
            throw new \InvalidArgumentException('Try sending these parameters here: [title => string, description => string, type => work|shopping, priority => int]');

        $customMessages = [
            'type.in' => 'The task type you provided is not supported. You can only use shopping or work.'
        ];

        $rules = [
            'title' => 'required',
            'priority' => 'integer',
            'type' => 'required|in:work,shopping',
        ];

        $validator = Validator::make($inputs, $rules, $customMessages);

        if ($validator->fails())
            throw new \InvalidArgumentException(implode(', ', $validator->errors()->all()));

        return true;
    }

}
