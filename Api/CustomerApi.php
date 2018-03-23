<?php
class CustomerApi extends BaseApi
{
    /**
     * @return Exception|mixed
     * This will return the created customer if success
     * or will return exception message if fails
     */
    public function createCustomer()
    {
        $customerData = [
            'customer'=>[
                "email"=>"ajith.ranatunga+100113@netstarter.com",
                "firstname" => "Ajith K",
                "lastname" => 'Ranatunga',
                "storeId" => 1,
                "websiteId" => 1,
                "addresses" => [
                    "defaultShipping" => true,
                    "defaultBilling" => true,
                    "firstname" => 'Ajith K',
                    "lastname" => 'Ranatunga',
                    "region" => [
                        "regionCode" => "NY",
                        "region" => 'New York',
                        "regionId" => 43
                    ],
                    "postcode" => "10755",
                    "street" => ["123 oak ave"],
                    "city" => "Purchase",
                    "telephone" => "512-555-1111",
                    "countryId" => "US"
                ]
            ],
            "password"=>"nets_123"
        ];




        /*$customerData = array(
            'customer' => array(
                "email" => "jdoe@example.com",
		        "firstname" => "Jane",
		        "lastname" => "Doe",
                "addresses" => array(
                    array(
                        "defaultShipping" => true,
                        "defaultBilling" => true,
                        "firstname" => "Jane",
                        "lastname" => "Doe",
                    )
                )
            ),
            'password' => 'nets123'
        )
        $customerData = [
            "customer" => [
                "email" => "ajith.ranatunga+hack@netstarter.com",
                "firstname" => "Jane",
                "lastname" => "Doe",
                "addresses" => [
                    "defaultShipping" => true,
                    "defaultBilling" => true,
                    "firstname" => "Jane",
                    "lastname" => "Doe",
                    "region" => (object)[
                        "region_code" => "NY",
                        "region" => "New York",
                        "region_id" => 43
                    ],
                "postcode" => "10755",
                "street" => ["123 Oak Ave"],
                "city" => "Purchase",
                "telephone" => "512-555-1111",
                "countryId" => "US"
		        ]
	        ],
             "password" => "Password1"
        ];*/

        $customerUrl = Config::BASE_URL.'/customers';
        $headers = array("Authorization: Bearer " . $this->adminToken);
        $customer = $this->curlExecute($customerUrl, $headers, $customerData);
        return $customer;
    }

    /**
     * @return Exception|mixed Customer Auth Code on success
     */
    public function customerLogin($customer)
    {
        $customerData = json_encode($customer);
        $loginUrl = Config::BASE_URL.'/integration/customer/token';
        $headers = array("Content-Length: ".strlen($customerData));
        $customerAuth = $this->curlExecute($loginUrl, $headers, $customerData);
        return $customerAuth;
    }
}