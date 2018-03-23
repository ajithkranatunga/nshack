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
        //$user = $_POST['userObject'];
        $customer = array("username" => "ajith.ranatunga@netstarter.com", "password" => "nets_123");
        $baseCustomer = array(
            "firstname"=> "Ajith",
            "lastname"=> "Ranatunga",
            "email"=> "ajith.ranatunga@netstarter.com",
            "telephone"=> "071-323 4356",
        );

        $baseAddress = array(
            "region"=> "New York",
            "region_id"=> 43,
            "region_code"=> "NY",
            "country_id"=> "US",
            "street"=> [
                "123 Oak Ave"
            ],
            "postcode"=> "10577",
            "city"=> "Purchase",
        );
        $shippingAddress = array("same_as_billing"=> 1, "customer_id"=> 3);
        $shippingAddress = array("address"=>array_merge($baseAddress, $baseCustomer, $shippingAddress));

        $billingData = array(
            "addressInformation" => array(
                "shipping_address" => $shippingAddress['address'],
                "billing_address" => $shippingAddress['address'],
                "shipping_carrier_code" => "tablerate",
                "shipping_method_code" => "bestway"
            )
        );

        $paymentInfo = array(
            "paymentMethod"=> array(
                "method"=> "banktransfer"
            ),
            "billing_address"=> $shippingAddress['address']
        );
        $customerAuthCode = $this->customerApi->customerLogin($customer);
        $quoteItem = $this->cartApi->createQuoteItem($customerAuthCode);
        $cart = $this->cartApi->addToCart($customerAuthCode,$quoteItem, '24-WB04', 2);
        $shipping = $this->cartApi->estimateShippingCost($customerAuthCode,$shippingAddress);
        $billingInfo = $this->cartApi->setBillingAndShippingInfo($customerAuthCode, $billingData);
        $order = $this->cartApi->sendPaymentInfo($customerAuthCode, $paymentInfo);
        echo (int)$order;
    }
}