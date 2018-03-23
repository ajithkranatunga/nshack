<?php
class Order
{
    protected $customerApi;

    protected $cartApi;
    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->customerApi = new CustomerApi();

        $this->cartApi = new CartApi();
    }

    public function placeOrder()
    {
        $customer = array("username" => "roni_cost@example.com", "password" => "roni_cost3@example.com");
        $shippingAddress = array(
            "address" => array(
                "region"=> "New York",
                "region_id"=> 43,
                "region_code"=> "NY",
                "country_id"=> "US",
                "street"=> [
                    "123 Oak Ave"
                ],
                "postcode"=> "10577",
                "city"=> "Purchase",
                "firstname"=> "Jane",
                "lastname"=> "Doe",
                "customer_id"=> 4,
                "email"=> "jdoe@example.com",
                "telephone"=> "(512) 555-1111",
                "same_as_billing"=> 1
            )
        );
        $billingAddress = array(
            "addressInformation" => array(
                "shipping_address" => array(
                    "region" => "New York",
                    "region_id" => 43,
                    "region_code" => "NY",
                    "country_id" => "US",
                    "street" => [
                        "123 Oak Ave"
                    ],
                    "postcode" => "10577",
                    "city" => "Purchase",
                    "firstname" => "Jane",
                    "lastname" => "Doe",
                    "email" => "jdoe@example.com",
                    "telephone" => "512-555-1111"
                ),
                "billing_address" => array(
                    "region" => "New York",
                    "region_id" => 43,
                    "region_code" => "NY",
                    "country_id" => "US",
                    "street" => ["123 Oak Ave"],
                    "postcode" => "10577",
                    "city" => "Purchase",
                    "firstname" => "Jane",
                    "lastname" => "Doe",
                    "email" => "jdoe@example.com",
                    "telephone" => "512-555-1111"
                ),
                "shipping_carrier_code" => "tablerate",
                "shipping_method_code" => "bestway"
            )
        );
        $paymentInfo = array(
            "paymentMethod"=> array(
                "method"=> "banktransfer"
            ),
            "billing_address"=> array(
                "email"=> "jdoe@example.com",
                "region"=> "New York",
                "region_id"=> 43,
                "region_code"=> "NY",
                "country_id"=> "US",
                "street"=> ["123 Oak Ave"],
                "postcode"=> "10577",
                "city"=> "Purchase",
                "telephone"=> "512-555-1111",
                "firstname"=> "Jane",
                "lastname"=> "Doe"
            )
        );
        $customerAuthCode = $this->customerApi->customerLogin($customer);
        $quoteItem = $this->cartApi->createQuoteItem($customerAuthCode);
        $cart = $this->cartApi->addToCart($customerAuthCode,$quoteItem, '24-WB04', 2);
        $shipping = $this->cartApi->estimateShippingCost($customerAuthCode,$shippingAddress);
        $billingInfo = $this->cartApi->setBillingAndShippingInfo($customerAuthCode, $billingAddress);
        $order = $this->cartApi->sendPaymentInfo($customerAuthCode, $paymentInfo);
        var_dump($order);
    }
}