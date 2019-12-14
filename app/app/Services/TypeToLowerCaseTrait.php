<?php

namespace App\Services;

trait TypeToLowerCaseTrait
{
    private function changeTypeToLowerCase(array $dataInputs): array
    {
        if (! array_key_exists('type', $dataInputs)) {
            return $dataInputs;
        }

        $dataInputs['type'] = mb_strtolower($dataInputs['type']);

        return $dataInputs;
    }
}
