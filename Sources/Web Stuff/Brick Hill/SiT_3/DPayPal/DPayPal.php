<?php

class DPayPal {

    //API Credentials
    protected $username = ""; //PayPal API username
    protected $password = ""; //PayPal API password
    protected $apiSignature = ""; //PayPal API signature
    protected $apiVersion = "74.0"; //Set PayPal API version
    //If you are using live environment use the following URL: https://api-3t.paypal.com/nvp 
    //If you are using sandbox environment then use the following URL: https://api-3t.sandbox.paypal.com/nvp
    protected $payPalAPIUrl = "https://api-3t.sandbox.paypal.com/nvp";
    protected $errorReportingEnabled = true;
    protected $errors = array(); //Here you can find errors for your last API call 
    protected $lastServerResponse; //Here you can find PayPal response for your last successfull API call
    protected $curl;

    /**
     * The SetExpressCheckout API operation initiates an Express Checkout transaction. Look here to see method parameters: https://developer.paypal.com/docs/classic/api/merchant/SetExpressCheckout_API_Operation_NVP/
     * @param array $request Array should contain key value pairs defined by PayPal
     * @return array Response from the PayPal saved in the array and returned from the function
     */
    public function SetExpressCheckout($request) {
        return $this->sendRequest($request, "SetExpressCheckout");
    }
    /**
     * The DoExpressCheckoutPayment API operation completes an Express Checkout transaction. If you set up a billing agreement in your SetExpressCheckout API call, the billing agreement is created when you call the DoExpressCheckoutPayment API operation.The DoExpressCheckoutPayment API operation completes an Express Checkout transaction. If you set up a billing agreement in your SetExpressCheckout API call, the billing agreement is created when you call the DoExpressCheckoutPayment API operation. Look here to see method parameters: https://developer.paypal.com/docs/classic/api/merchant/DoExpressCheckoutPayment_API_Operation_NVP/
     * @param array $request Array should contain key value pairs defined by PayPal
     * @return array Response from the PayPal saved in the array and returned from the function
     */
    public function DoExpressCheckoutPayment($request) {
        return $this->sendRequest($request, "DoExpressCheckoutPayment");
    }
    /**
     * Calles GetExpressCheckoutDetails PayPal API method. This method gets buyer and transaction data. This method WILL NOT- make transaction itself. Look here for method parameters: https://developer.paypal.com/docs/classic/api/merchant/GetExpressCheckoutDetails_API_Operation_NVP/
     * @param array $request Array should contain key value pairs defined by PayPal
     * @return array Response from the PayPal saved in the array and returned from the function
     */
    public function GetExpressCheckoutDetails($request) {
        return $this->sendRequest($request, "GetExpressCheckoutDetails");
    }
    
    
     public function DoAuthorization($request){
        return $this->sendRequest($request, "DoAuthorization");
    }
    
    /* AUTORIZATION AND CAPTURE METHODS*/
    /**
     * Captures an authorized payment. You can read more about authorization and payment: https://developer.paypal.com/docs/classic/admin/auth-capture/
     * @param array $request
     * @return array
     */
    public function DoCapture($request){
        return $this->sendRequest($request, "DoCapture");
    }
    /**
     * The DoReauthorization API operation reauthorizes an existing authorization transaction. The resulting reauthorization is a new transaction with a new AUTHORIZATIONID. To see method arguments visit this link: https://developer.paypal.com/docs/classic/api/merchant/DoReauthorization_API_Operation_NVP/
     * @param array $request
     * @return array
     */
    public function DoReauthorization($request){
        return $this->sendRequest($request, "DoReauthorization");
    }
    /**
     * Void an order or an authorization. To see method arguments visit this link: https://developer.paypal.com/docs/classic/api/merchant/DoVoid_API_Operation_NVP/
     * @param array $request
     * @return array
     */
    public function DoVoid($request){
        return $this->sendRequest($request, "DoVoid");
    }
    
    /**
     * To see method arguments visit this link: 
     * @param array $request
     * @return array
     */
    public function UpdateAuthorization($request){
        return $this->sendRequest($request, "UpdateAuthorization");
    }
    
    
    /*Recurring Payments / Reference Transactions*/
    
    /**
     * The BAUpdate API operation updates or deletes a billing agreement. To see method arguments visit this link: https://developer.paypal.com/docs/classic/api/merchant/BAUpdate_API_Operation_NVP/
     * @param array $request
     * @return array
     */
    public function BAUpdate($request){
        return $this->sendRequest($request, "BAUpdate");
    }
    /**
     * The BillOutstandingAmount API operation bills the buyer for the outstanding balance associated with a recurring payments profile. To see method arguments visit this link: https://developer.paypal.com/docs/classic/api/merchant/BillOutstandingAmount_API_Operation_NVP/
     * @param array $request
     * @return array
     */
    public function BillOutstandingAmount($request){
        return $this->sendRequest($request, "BillOutstandingAmount");
    }
    /**
     * The CreateBillingAgreement API operation creates a billing agreement with a PayPal account holder. CreateBillingAgreement is only valid for reference transactions. To see method arguments visit this link: https://developer.paypal.com/docs/classic/api/merchant/CreateBillingAgreement_API_Operation_NVP/
     * @param array $request
     * @return array
     */
    public function CreateBillingAgreement($request){
        return $this->sendRequest($request, "CreateBillingAgreement");
    }
    /**
     * The DoReferenceTransaction API operation processes a payment from a buyer's account, which is identified by a previous transaction. To see method arguments visit this link: https://developer.paypal.com/docs/classic/api/merchant/DoReferenceTransaction_API_Operation_NVP/
     * @param array $request
     * @return array
     */
    public function CreateRecurringPaymentsProfile($request){
        return $this->sendRequest($request, "CreateRecurringPaymentsProfile");
    }
    /**
     * The DoReferenceTransaction API operation processes a payment from a buyer's account, which is identified by a previous transaction. To see method arguments visit this link: https://developer.paypal.com/docs/classic/api/merchant/DoReferenceTransaction_API_Operation_NVP/
     * @param array $request
     * @return array
     */
    public function DoReferenceTransaction($request){
        return $this->sendRequest($request, "DoReferenceTransaction");
    }
    
    /**
     * Obtain information about a recurring payments profile. To see method arguments visit this link: https://developer.paypal.com/docs/classic/api/merchant/GetRecurringPaymentsProfileDetails_API_Operation_NVP/
     * @param array $request
     * @return array
     */
    public function GetRecurringPaymentsProfileDetails($request){
        return $this->sendRequest($request, "GetRecurringPaymentsProfileDetails");
    }
    /**
     * The ManageRecurringPaymentsProfileStatus API operation cancels, suspends, or reactivates a recurring payments profile. To see method arguments visit this link: https://developer.paypal.com/docs/classic/api/merchant/ManageRecurringPaymentsProfileStatus_API_Operation_NVP/
     * @param array $request
     * @return array
     */
    public function ManageRecurringPaymentsProfileStatus($request){
        return $this->sendRequest($request, "ManageRecurringPaymentsProfileStatus");
    }
    /**
     * The UpdateRecurringPaymentsProfile API operation updates a recurring payments profile. To see method arguments visit this link: https://developer.paypal.com/docs/classic/api/merchant/UpdateRecurringPaymentsProfile_API_Operation_NVP/
     * @param array $request
     * @return array
     */
    public function UpdateRecurringPaymentsProfile($request){
        return $this->sendRequest($request, "UpdateRecurringPaymentsProfile");
    }
    /**
     * The RefundTransaction API operation issues a refund to the PayPal account holder associated with a transaction. This API operation can be used to issue a full or partial refund for any transaction within a default period of 60 days from when the payment is received. To see method arguments visit this link: https://developer.paypal.com/docs/classic/api/merchant/RefundTransaction_API_Operation_NVP/
     * @param array $request
     * @return array
     */
    public function RefundTransaction($request){
        return $this->sendRequest($request, "RefundTransaction");
    }
    
    
    /**
     * This method makes calls PayPal method provided as argument.
     * @param array $requestData
     * @param string $method
     * @return array 
     */
    public function sendRequest($requestData, $method) {

        if (!isset($method)) {
            array_push($this->errors, "Method name can not be empty");
        }
        if (!isset($requestData)) {
            array_push($this->errors, "Request data is can not be empty");
        }

        if ($this->checkForErrors()) {//If there are errors, STOP
            if ($this->errorReportingEnabled())//If error reporting is enabled, show errors
                $this->showErrors();

            $this->lastServerResponse = null;
            return false; //Do not send a request
        }
        $requestParameters = array(
            "USER" => $this->username,
            "PWD" => $this->password,
            "SIGNATURE" => $this->apiSignature,
            "METHOD" => $method,
            "VERSION" => $this->apiVersion,
        );
        $requestParameters+=$requestData;
        $finalRequest = http_build_query($requestParameters);

        $ch = curl_init();
        $this->curl=$ch;
        
        $curlOptions=$this->getcURLOptions();
        $curlOptions[CURLOPT_POSTFIELDS]=$finalRequest;
        //var_dump($curlOptions);exit;
        
        curl_setopt_array($ch, $curlOptions);
        $serverResponse = curl_exec($ch);

        if (curl_errno($ch)) {
            $this->errors = curl_error($ch);
            curl_close($ch);
            if ($this->errorReportingEnabled) {
                $this->showErrors();
            }
            $this->lastServerResponse = null;
            return false;
        } else {
            curl_close($ch);
            $result = array();
            parse_str($serverResponse, $result);
            $this->lastServerResponse = $result;
            return $this->lastServerResponse;
        }
    }
    /**
     * Returns latest result from the PayPal servers
     * @return array
     */
    public function getLastServerResponse() {
        return $this->lastServerResponse;
    }
    /** 
     * Call this function if you want to retreave errors occured during last API call
     * @return void Prints all errors during last API call.
     */
    public function showErrors() {
        var_dump($this->errors);
    }
    /**
     * 
     * @param string $username Set your PayPal API username
     */
    public function setUsername($username) {
        $this->username = $username;
    }
    /**
     * 
     * @param string $password Set your PayPal API password
     */
    public function setPassword($password) {
        $this->password = $password;
    }
    /**
     * 
     * @param string $apiSignature Set your PayPal API signature
     */
    public function setApiSignature($apiSignature) {
        $this->apiSignature = $apiSignature;
    }
    /**
     * Call this function if you want to disable error reporting
     */
    public function disableErrorReporting(){
        $this->errorReportingEnabled=false;
    }
    /**
     * Call this function if you want to enable error reporting
     */
    public function enableErrorReporting(){
        $this->errorReportingEnabled=true;
    }

    /**
     * 
     * @return boolean Checks if there are errors and returns the true/false
     */
    private function checkForErrors() {
        
        if(!is_array($this->errors) && $this->errors!="") return TRUE;
        
        if (count($this->errors) > 0) {
            return true;
        }
        return false;
    }
    /**
     * Returns an array of options to initialize cURL
     * @return array
     */
    private function getcURLOptions() {
        return array(
            CURLOPT_URL => $this->payPalAPIUrl,
            CURLOPT_VERBOSE => 1,
            //Have a look at this: http://stackoverflow.com/questions/14951802/paypal-ipn-unable-to-get-local-issuer-certificate
            //You can download a fresh cURL pem file from here http://curl.haxx.se/ca/cacert.pem
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_CAINFO => dirname(__FILE__) . '/cacert.pem', //CA cert file
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_POST => 1,
        );
    }
    
    /**
     * If you want to set cURL with additional parameters, use this function. NOTE: Call this function prior sendRequest method
     * @param int $option
     * @param mixed $value
     */
    public function setCURLOption($option, $value){
        curl_setopt($this->curl, $option, $value);
    }

}
