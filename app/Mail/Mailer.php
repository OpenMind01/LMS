<?php
/**
 * Created by Justin McCombs.
 * Date: 11/30/15
 * Time: 12:09 PM
 */

namespace Pi\Mail;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Pi\Exceptions\Mail\EmailAddressNotValidException;
use Pi\Exceptions\Mail\EmailTemplateNotFoundException;
use Pi\Exceptions\Mail\EmailValidationFailedException;
use Pi\Jobs\SendCampaignMonitorEmail;

class Mailer
{

    use DispatchesJobs;
    /**
     * @var array
     */
    protected $auth;

    /**
     * @var array
     */
    protected $globalVars;

    public function __construct()
    {
        $this->auth = ['api_key' => config('services.campaignmonitor.key')];

        $this->globalVars = [
            'url' => url(),
        ];
    }

    /**
     * Sends an email via the CampaignMonitor API
     *
     * @param string $name
     * @param string $to
     * @param array $data
     * @return \CS_REST_Wrapper_Result
     * @throws EmailAddressNotValidException
     * @throws EmailTemplateNotFoundException
     * @throws EmailValidationFailedException
     */
    public function send($name = '', $to = '', array $data = [])
    {
        // Does template exist?
        $templateArray = config('p4mailer.templates.'.$name);

        if ( ! $templateArray )
            throw new EmailTemplateNotFoundException('Could not find an email template with the name ' . $name . ' in the p4mailer.php config file.');

        // Is data valid?
        $v = \Validator::make($data, $templateArray['validation']);
        if ($v->fails())
        {
            $e = new EmailValidationFailedException('Could not validate the email data.');
            $e->setErrors($v->errors());
            throw $e;
        }

        if ( ! app()->environment() === 'production' && env('FORCE_DEV_EMAIL')) {
            $to = env('DEV_TEST_EMAIL');
        }

        // Is email valid?
        if ( ! \Swift_Validate::email($to) )
            throw new EmailAddressNotValidException($to . ' is not a valid email address.');

        $dataToSend = $this->globalVars;

        foreach($data as $key => $value)
        {
            $dataToSend[$key] = $value;
        }

        $message = [
            'To' => $to,
            'Data' => $dataToSend
        ];

        $this->dispatchFromArray(SendCampaignMonitorEmail::class, [
            'id' => $templateArray['id'],
            'auth' => $this->auth,
            'message' => $message
        ]);

    }

}