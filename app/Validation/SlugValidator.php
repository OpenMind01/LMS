<?php
/**
 * Created by Justin McCombs.
 * Date: 10/2/15
 * Time: 4:11 PM
 */

namespace Pi\Validation;


class SlugValidator
{

    public function validate($attribute, $value, $parameters)
    {
        $pattern = '/^[a-z0-9]+(?:-[a-z0-9]+)*$/';
        return preg_match($pattern, $value);
    }

    public function getMessage($message, $attribute, $rule, $parameters)
    {
        return $message;
    }

}