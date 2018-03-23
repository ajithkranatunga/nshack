<?php
class BaseApi
{
    /**
     * @var string
     */
    protected $adminToken;

    /**
     * BaseApi constructor.
     */
    public function __construct()
    {
//        $this->adminToken = $this->getAccessToken();
    }

    /**
     * generates access token for Admin authentication
     * @return string admin Token
     */
    public function getAccessToken()
    {
        $adminUser = array(
            "username" => Config::API_USER_NAME,
            "password" => Config::API_USER_PASSWORD
        );
        $adminUserData = json_encode($adminUser);
        $adminTokenUrl = Config::BASE_URL.'/integration/admin/token';
        $headers = array("Content-Length: ".strlen($adminUserData));
        $adminToken = $this->curlExecute($adminTokenUrl, $headers, $adminUserData);
        return $adminToken;
    }

    /**
     * A function to execute API calls with admin permissions. Admin token will be passed in the function.
     * @param $requestUrl
     * @return mixed
     */
    function getAdminApiResult($requestUrl){

        $headers = array("Authorization: Bearer ".$this->adminToken);
        $curlResult = $this->curlExecute($requestUrl,$headers);
        return $curlResult;
    }

    /**
     * Generic method to handle all the curl requests
     * @param $curlUrl
     * @param $headers Authcode also should send in this if applicable
     * @param null $curlData
     * @param string $curlMtd
     * @return Exception|mixed json decoded result of curl execution
     */
    public function curlExecute($curlUrl, $headers, $curlData = null, $curlMtd = "POST")
    {
        $headers[] = "Content-Type: application/json";

        try{
            $curl = curl_init($curlUrl);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $curlMtd);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            if($curlData){
                curl_setopt($curl, CURLOPT_POSTFIELDS, $curlData);
            }
            $result = curl_exec($curl);
            $result=  json_decode($result);
            return $result;
        } catch (Exception $exception){
            return $exception;
        }
    }
}