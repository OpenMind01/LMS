<?php
/**
 * Created by Justin McCombs.
 * Date: 11/30/15
 * Time: 12:26 PM
 */

namespace Pi\Exceptions\Mail;


class EmailValidationFailedException extends \Exception
{

    protected $errors;

    public function setErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }

    public function errors()
    {
        return $this->errors;
    }
}