<?php
/**
 * Created by Justin McCombs.
 * Date: 12/7/15
 * Time: 5:46 PM
 */

namespace Pi\Mail\Incoming\Handlers;


class EmailHandler
{
    public $subjectRegex;

    public function handle($subject, $from, $bodyHtml, $bodyPlain)
    {
        //
    }

    /**
     * @param $subject
     * @return bool
     */
    public function matches($subject) {
        if ($this->subjectRegex)
            return (bool) preg_match($this->subjectRegex, $subject);

        return false;
    }

    protected function getEmailFromString($string)
    {
        $stringArray = explode(' ', $string);
        if ( ! $stringArray )
            return (filter_var($string, FILTER_VALIDATE_EMAIL)) ? $string : null;
        foreach($stringArray as $subStr) {
            if (filter_var($subStr, FILTER_VALIDATE_EMAIL))
                return $subStr;
        }
        return null;
    }
}