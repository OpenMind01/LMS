<?php
/**
 * Created by Justin McCombs.
 * Date: 12/7/15
 * Time: 5:47 PM
 */

namespace Pi\Mail\Incoming;


use Illuminate\Support\Collection;
use Pi\Mail\Incoming\Handlers\DiscussionGroupRaiseHandReply;

class IncomingMailService
{

    protected $handlers;

    public function __construct()
    {
        $this->handlers = new Collection([
            app()->make(DiscussionGroupRaiseHandReply::class),
        ]);
    }

    public function handle($subject, $from, $bodyHtml, $bodyPlain)
    {
        foreach($this->handlers as $handler)
        {
            if ($handler->matches($subject)) {
                return $handler->handle($subject, $from, $bodyHtml, $bodyPlain);
            }
        }
    }

}