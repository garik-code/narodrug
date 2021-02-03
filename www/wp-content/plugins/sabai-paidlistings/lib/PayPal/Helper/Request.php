<?php
class Sabai_Addon_PayPal_Helper_Request extends Sabai_Helper
{   
    /**
     * @param Sabai $application
     * @param string $method
     * @param array $params
     */
    public function help(Sabai $application, $method, array $params)
    {
        $config = $application->getAddon('PayPal')->getConfig();
        // Live or sandbox?
        if (empty($config['sb'])) {
            $pp_user = $config['user'];
            $pp_pwd = $config['pwd'];
            if ($config['cred'] === 'cert') {
                $pp_cert = $config['cert'];
                $pp_endpoint = 'https://api.paypal.com/nvp';
            } else {
                $pp_signature = $config['sig'];
                $pp_endpoint = 'https://api-3t.paypal.com/nvp';
            }
        } else {
            $pp_user = $config['sb_user'];
            $pp_pwd = $config['sb_pwd'];
            if ($config['sb_cred'] === 'cert') {
                $pp_cert = $config['sb_cert'];
                $pp_endpoint = 'https://api.sandbox.paypal.com/nvp';
            } else {
                $pp_signature = $config['sb_sig'];
                $pp_endpoint = 'https://api-3t.sandbox.paypal.com/nvp';
            }
        }
        if (!$pp_user
            || !$pp_pwd
            || (empty($pp_signature) && empty($pp_cert))
        ) {
            throw new Sabai_InvalidArgumentException('Invalid PayPal API configuration.');
        }
         
        // Init request parameters
        $params += array(
            'METHOD' => $method,
            'VERSION' => isset($config['version']) ? $config['version'] : '63.0',
            'USER' => $pp_user,
            'PWD' => $pp_pwd,
        );
        if (isset($pp_signature)) {
            $params['SIGNATURE'] = $pp_signature;
        }

        //cURL settings
        $curl_options = array (
            CURLOPT_SSLVERSION => 1,
            //CURLOPT_SSL_CIPHER_LIST => 'TLSv1',
            CURLOPT_URL => $pp_endpoint,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_CAINFO => $application->getAddonPath('PayPal') . '/cacert.pem',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params, '', '&'),
            CURLOPT_TIMEOUT => 300,
        );
        if (!empty($pp_cert)) {
            $curl_options[CURLOPT_SSLCERT] = $pp_cert;
        }

        $ch = curl_init();
        curl_setopt_array($ch, $curl_options);

        //Sending our request - $response will hold the API response
        $response = curl_exec($ch);

        //Checking for cURL errors
        if (curl_errno($ch)) {            
            $e = new Sabai_RuntimeException(curl_error($ch), curl_errno($ch));
            curl_close($ch);
            throw $e;
        }
        
        curl_close($ch);
        $ret = array();
        parse_str($response, $ret); // Break the NVP string to an array
        
        if ('Success' !== $ret['ACK']
            && 'SuccessWithWarning' !== $ret['ACK']
        ) {
            throw new Sabai_RuntimeException($ret['L_LONGMESSAGE0'], $ret['L_ERRORCODE0']);
        }
        
        return $ret;
    }
}