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
     * login to AdobeConnect In http:/online.techone24.com
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

    public function getListUsers()
    {
        if ($this->login()) {
        $query = [
            'action'=>'principal-list',
           
        ];

        return $this->httpRequest->HTTPGet(self::URL,$query);
    }
        
    }

}
