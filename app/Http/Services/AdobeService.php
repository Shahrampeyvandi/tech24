<?php


namespace App\Http\Services;


/**
 * Class AdobeService
 * @package App\Http\Services
 */
class AdobeService
{

    protected const URL = 'http://online.techone24.com/api/xml';
    public HTTPRequest $httpRequest;
    public static ?AdobeService $service;


    public function __construct()
    {
        $this->httpRequest = new HTTPRequest();
        self::$service = $this;
    }


    /**
     * login to adobe connect
     *
     * @return bool|string
     */
    public function login()
    {
        $query = [
            'action'=>'login',
            'login' => env('ADOBE_CONNECT_USER_NAME'),
            'password'=> env('ADOBE_CONNECT_PASSWORD')
        ];

       return $this->httpRequest->HTTPGet(self::URL,$query);
    }


    /**
     * @param string $groupName
     * @return bool|string
     */
    public function createGroup(string $groupName)
    {
        if ($this->login()) {

            $query = [
                'action'=>'principal-update',
                'has-children' => '1',
                'type'=> 'group',
                'name'=> $groupName,
            ];

            return $this->httpRequest->HTTPGet(self::URL,$query);
        }

    }



}
