<?php

namespace LegacyApp;

class CreditCard
{
    /**
     * @var string
     */
    public $number = null;

    /**
     * @var string|bool
     */
    private $error = 'ERROR_NOT_SET';

    public function checkLength(int $length, int $category)
    {
        if ($category == 0) {
            return ($length == 13) || ($length == 16);
        } elseif ($category == 1) {
            return ($length == 16) || ($length == 18) || ($length == 19);
        } elseif ($category == 2) {
            return $length == 16;
        } elseif ($category == 3) {
            return $length == 15;
        } elseif ($category == 4) {
            return $length == 14;
        } else {
            return 1;
        }
    }

    public function isValid(string $rawNumber = null)
    {
        if (is_null($rawNumber)) {
            return $this->error = 'ERROR_INVALID_CHAR';
        }

        $sanitizedValue = preg_replace('/\D+/', '', $rawNumber);

        /**
         *  Visa = 4XXX - XXXX - XXXX - XXXX.
            MasterCard = 5[1-5]XX - XXXX - XXXX - XXXX
            Discover = 6011 - XXXX - XXXX - XXXX
            Amex = 3[4,7]X - XXXX - XXXX - XXXX
            Diners = 3[0,6,8] - XXXX - XXXX - XXXX
            Any Bankcard = 5610 - XXXX - XXXX - XXXX
            JCB =  [3088|3096|3112|3158|3337|3528] - XXXX - XXXX - XXXX
            Enroute = [2014|2149] - XXXX - XXXX - XXX
            Switch = [4903|4911|4936|5641|6333|6759|6334|6767] - XXXX - XXXX - XXXX
         */

        if ($sanitizedValue[0] == '4') {
            $lencat = 2;
        } elseif ($sanitizedValue[0] == '5') {
            $lencat = 2;
        } elseif ($sanitizedValue[0] == '3') {
            $lencat = 4;
        } elseif ($sanitizedValue[0] == '2') {
            $lencat = 3;
        } else {
            $lencat = 0;
        }

        if (! $this->checkLength(strlen($sanitizedValue), $lencat)) {
            $this->error = 'ERROR_INVALID_LENGTH';
        } else {
            $this->number = $sanitizedValue;
            $this->error = true;
        }

        return $this->error;
    }

    public function set(string $number = null)
    {
        if (! is_null($number)) {
            return $this->isValid($number);
        }

        $this->number = null;
        $this->error = 'ERROR_NOT_SET';

        return 'ERROR_NOT_SET';
    }

    // ************************************************************************
    // Description: retrieve the current card number. the number is returned
    //              unformatted suitable for use with submission to payment and
    //              authorization gateways.
    //
    // Parameters:  none
    //
    // Returns:     card number
    // ************************************************************************
    public function get()
    {
        return @$this->number;
    }
}
