<?php


namespace App\Http\Services;

use App\Payment;
use App\Post;
use App\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class PaymentService
 * @package App\Http\Services
 */
class PaymentService
{

    protected const URL = 'https://www.zarinpal.com/pg/rest/WebGate/PaymentRequest.json';
    protected const TEST_URL = 'https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentRequest.json';
    protected const MERCHANT_ID = '2a00b862-a97e-11e6-9e29-005056a205be';
    public $debugMode = 1;
    public HTTPRequest $httpRequest;
    public static ?PaymentService $service;
    public User $user;
    public Post $post;
    public $callBack;
    public Payment $payment;


    public function __construct(User $user , Post $post , $callBack)
    {
        $this->httpRequest = new HTTPRequest();
        self::$service = $this;
        $this->user = $user;
        $this->post = $post;
        $this->payment = new Payment();
        $this->callBack = $callBack;

    }
  


    /**
     * login to AdobeConnect In http:/online.techone24.com
     *
     * @return bool|string
     */
    public function start()
    {
         $payment = new Payment;
         $payment->user_id = $this->user->id;
         $payment->post_id = $this->post->id;
         $payment->amount =  $this->post->price;
         $payment->save();

         $this->payment = $payment;

        

        $data = array(
            'MerchantID' => self::MERCHANT_ID,
            'Amount' => $this->payment->amount,
            'CallbackURL' => $this->callBack . '?id=' . $this->payment->id,
            'Description' => 'پرداخت از سایت'
        );
        
        if($this->debugMode == 1) {
            $url = self::TEST_URL;
        }else{
            $url = self::URL;
        }

       return $this->httpRequest->HTTPPost($url,$data);
    }


    /**
     * @param string $groupName
     * @return bool|string
     */
    protected function callBack(string $groupName)
    {
       

    }


    /**
     * Add User in AdobeConnect In http:/online.techone24.com
     * 
     * @param string $groupName
     * @return bool|string
     */
    public function addUserInAdobe(object $user)
    {
        if ($this->login()) {

            $query = [
                'action'=>'principal-update',
                'first-name' => str_replace(' ', '', $user->fname),
                'last-name'=> str_replace(' ', '', $user->lname),
                'has-children' => '0',
                'login'=> $user->email,
                'type' => 'user'
            ];

            return $this->httpRequest->HTTPGet(self::URL,$query);
        }

    }


    
    /**
     * Add User in AdobeConnect Group In http:/online.techone24.com
     * 
     * @param string $groupName
     * @return bool|string
     */
    public function addUserInAdobeGroup($principalId,$groupId)
    {
        if ($this->login()) {

            $query = [
                'action'=>'group-membership-update',
                'group-id' => $groupId,
                'principal-id'=> $principalId,
                'is-member' => '1',
               
            ];

            return $this->httpRequest->HTTPGet(self::URL,$query);
        }

    }


}
