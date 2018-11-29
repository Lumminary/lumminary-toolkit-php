<?php namespace AppToolkit;

class Product
{
    private $_apiClient = null;

    public function __construct($uuid, $apiKey, $apiHost)
    {
        $this->_uuid = $uuid;
        $this->_apiKey = $apiKey;
        $this->_apiHost = $apiHost;
    }

    public function _getClient()
    {
        if(is_null($this->_apiClient))
        {
            $credentials = new \Lumminary\Client\Credentials(
                /*host*/ $this->_apiHost,
                /*login*/ $this->_uuid,
                /*password*/ $this->_apiKey,
                /*role*/ "role_product"
            );
            $this->_apiClient = new \Lumminary\Client\LumminaryAPI($credentials);
        }

        return $this->_apiClient;
    }

    public function getAuthorizationsPending($authorizationOffset)
    {
        $apiClient = $this->_getClient();

        return $apiClient->getAuthorizationsQueue($this->_uuid, $authorizationOffset);
    }

    public function getDatasetSnps($clientUuid, $datasetUuid)
    {
        $apiClient = $this->_getClient();

        return $apiClient->getClientSnpGroup($clientUuid, $datasetUuid);
    }

    public function getEmail()
    {
        $apiClient = $this->_getClient();

        return $apiClient->getProduct($this->_uuid)["email"];
    }

    public function orderDataEmail($sendgridApiKey, $authorizationUuid, $dataAttachmentPath, $emailFrom)
    {
        $transport = (new \Swift_SmtpTransport('smtp.sendgrid.net', 587, 'tls'))
            ->setUsername("apikey")
            ->setPassword($sendgridApiKey);
        
        $mailer = new \Swift_Mailer($transport);

        $outboundMail = (new \Swift_Message("Lumminary authorization ".$authorizationUuid." - Customer data"))
            ->setFrom($emailFrom)
            ->setTo([
                $this->getEmail()
            ])
            ->setBody("Attached is the customer information for authorization ".$authorizationUuid)
            #->attach(\Swift_Attachment::fromPath($exportZipPath));
            ->attach(\Swift_Attachment::fromPath($dataAttachmentPath));
        
        return $mailer->send($outboundMail);
    }
}
