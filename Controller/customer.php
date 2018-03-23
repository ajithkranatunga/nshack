<?php
class Customer
{
    protected $customerApi;

    /**
     * Customer constructor.
     * @param $customerApi
     */
    public function __construct()
    {
        $this->customerApi = new CustomerApi();
    }


    public function login()
    {
        $customer = array("username" => "roni_cost@example.com", "password" => "roni_cost3@example.com");
        $customerToken = $this->customerApi->customerLogin($customer);
        echo json_encode($customerToken);
    }
}