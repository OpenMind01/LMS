<?php

namespace Pi\Http\Requests\Clients\Usergroups;

use Pi\Exceptions\IErrorMessageException;
use Pi\Http\Requests\Request;

class UsersInviteRequest extends Request
{
    public function rules()
    {
        return [
            'emails' => 'required',
        ];
    }

    public function getEmails()
    {
        $emailsStr = $this->get('emails');

        $arr = explode("\n", $emailsStr);
        $arr = array_map('trim', $arr);

        $emails = [];
        foreach($arr as $s)
        {
            $emailsArr = explode(',', $s);
            $emailsArr = array_map('trim', $emailsArr);

            foreach($emailsArr as $email)
            {
                if(empty($email)) continue;

                if(filter_var($email, FILTER_VALIDATE_EMAIL) === false)
                    throw new InvalidEmailException($email);

                $emails[] = $email;
            }
        }

        return $emails;
    }
}

class InvalidEmailException extends \Exception implements IErrorMessageException
{
    public function __construct($wrongEmail)
    {
        parent::__construct('Invalid email: ' . $wrongEmail);
    }
}