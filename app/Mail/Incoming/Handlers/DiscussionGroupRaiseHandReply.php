<?php
/**
 * Created by Justin McCombs.
 * Date: 12/7/15
 * Time: 5:46 PM
 */

namespace Pi\Mail\Incoming\Handlers;


use Pi\Auth\User;

class DiscussionGroupRaiseHandReply extends EmailHandler
{

    public $subjectRegex = '/((Re:\s?)*) Discussion Group Post (.*)/';

    public function handle($subject, $from, $bodyHtml, $bodyPlain)
    {

        // Get Email and User
        $email = $this->getEmailFromString($from);
        $user = User::whereEmail($email)->first();

        // UUID
        preg_match($this->subjectRegex, $subject, $matches);

        if (count($matches) > 1) {

            $uuid = end($matches);

            $responsePattern = '/=* Reply Above This Line =*/';
            $responseArray = preg_split($responsePattern, $bodyPlain);
            if(! $responseArray)
                return false;
            $response = $responseArray[0];


            // TODO: Create Thread

        }
    }



}