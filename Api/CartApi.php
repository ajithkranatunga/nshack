<?php
class CartApi extends BaseApi
{
    /**
     * @param $customerAuth
     * @return Exception|mixed QuoteItemId on success
     */
    public function createQuoteItem($customerAuth)
    {
        $quoteUrl = Config::BASE_URL.'/carts/mine';
        $headers = array("Authorization: Bearer " . $customerAuth);
        $quoteItem = $this->curlExecute($quoteUrl, $headers);
        return $quoteItem;
    }

    /**
     * @param $customerAuth
     * @param $quoteId
     * @param $sku
     * @param $qty
     * @return Exception|mixed Cart Item Info on success
     */
    public function addToCart($customerAuth, $quoteId, $sku, $qty)
    {
        $addToCartUrl = Config::BASE_URL.'/carts/mine/items';
        $cartData = array(
            "cartItem" => array(
                "sku" => $sku,
                "qty" => $qty,
                "quote_id" => $quoteId
            )
        );
        $cartData = json_encode($cartData);
        $headers = array("Authorization: Bearer " . $customerAuth);
        $cart = $this->curlExecute($addToCartUrl, $headers, $cartData);
        return $cart;
    }

    /**
     * @param $customerAuth
     * @param $shippingAddress
     * @return Exception|mixed Shipping Estimations on success
     */
    public function estimateShippingCost($customerAuth, $shippingAddress)
    {
        $estimateUrl = Config::BASE_URL.'/carts/mine/estimate-shipping-methods';
        $shippingAddressData  = json_encode($shippingAddress);
        $headers = array("Authorization: Bearer " . $customerAuth);
        $shippingEstimates = $this->curlExecute($estimateUrl, $headers, $shippingAddressData);
        return $shippingEstimates;
    }

    /**
     * @param $customerAuth
     * @param $billingData
     * @return Exception|mixed Billing and Shipping Info on success
     */
    public function setBillingAndShippingInfo($customerAuth, $billingData)
    {
        $billingUrl = Config::BASE_URL.'/carts/mine/shipping-information';
        $billingData = json_encode($billingData);
        $headers = array("Authorization: Bearer " . $customerAuth);
        $bnsInfo = $this->curlExecute($billingUrl,$headers, $billingData);
        return $bnsInfo;
    }

    /**
     * @param $customerAuth
     * @param $paymentInfo
     * @return Exception|mixed Order info on success
     */
    public function sendPaymentInfo($customerAuth, $paymentInfo)
    {
        $paymentInfoUrl = Config::BASE_URL.'/carts/mine/payment-information';
        $paymentData = json_encode($paymentInfo);
        $headers = array("Authorization: Bearer " . $customerAuth);
        $orderInfo = $this->curlExecute($paymentInfoUrl,$headers,$paymentData);
        return $orderInfo;
    }


}