<?php
namespace Imbehe\Http\Controllers\Auth;
use Imbehe\Http\Controllers\Controller;
use Imbehe\Services\SendNotification\SmsSendNotification;
use Imbehe\Subscriber;
use Hash;
class AuthController extends Controller {
    protected $sendNotification;
    function __construct(SmsSendNotification $sendNotification, Subscriber $subscriber) {
        $this->sendNotification = $sendNotification;
        $this->subscriber = $subscriber;
    }
    /**
     * Create a new subscriber instance after a valid registration.
     *
     * @param  array  $data
     * @return subscriber
     */
    public function registerMsisdn($msisdn) {
        // Generate the token
        $rememberToken = $msisdn . Hash::make($msisdn);
        // Prepare data and insert in the model
        $data = [
            'msisdn' => $msisdn,
            'code' => rand(10000, 99999),
            'remember_token' => $rememberToken,
        ];
        $this->subscriber->createOrUpdate($data);
        // Send verification code
        $this->sendSms($data);
        // Return generated token
        return $rememberToken;
    }
    /**
     * Code verification
     */
    public function verifyCode($msisdn, $code) {
        // Prepare data
        $data = [
            'msisdn' => $msisdn,
            'code' => $code,
        ];
        return (string) $this->subscriber->isValidCode($data);
    }

    /**
     * Send sms to the registered person
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    private function sendSms($data) {
        $message = 'Your code is:' . $data['code'] . ' to verify your imbeheApp account.';
        while (!$this->sendNotification->send($data['msisdn'], $message)) {
            sleep(1);
            $this->sendNotification->send($data['msisdn'], $message);
        }
        return true;
    }
}