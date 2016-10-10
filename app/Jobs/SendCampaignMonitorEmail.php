<?php

namespace Pi\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Pi\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class SendCampaignMonitorEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $auth;
    /**
     * @var
     */
    private $message;

    /**
     * Create a new job instance.
     *
     * @param $id
     * @param $auth
     * @param $message
     */
    public function __construct($id, $auth, $message)
    {
        //
        $this->id = $id;
        $this->auth = $auth;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Send Email
        $wrap = new \CS_REST_Transactional_SmartEmail($this->id, $this->auth);

        $result = $wrap->send($this->message);

        return $result;
    }
}
