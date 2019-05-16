<?php
namespace Lumminary\Client;

use Lumminary\Client\Api;
use Lumminary\Client\ApiException;

class LumminaryApi extends Api\LumminaryAPISpecApi
{
    const CONNECT_TIMEOUT_S = 10;
    const REQUEST_TIMEOUT_S = 3600;
    const CWL_ENCRYPTION_METHOD = "aes-256-gcm";
    const MAC_LENGTH_BYTES = 12;

    /**
     * The credentials used to authenticate to the API
     *
     * @var Lumminary\Client\Credentials
     */
    protected $_credentials;

    public function __construct($credentials, $connectTimeoutSeconds = LumminaryApi::CONNECT_TIMEOUT_S, $requestTimeoutSeconds = LumminaryApi::REQUEST_TIMEOUT_S)
    {
        $this->_credentials = $credentials;

        $strAuthenticationJWT = $this->_apiClientAuthenticate(
            $this->_credentials->getLogin(),
            $this->_credentials->getPassword(),
            $this->_credentials->getRole(),
            $this->_credentials->getHost()
        );

        $config = new Configuration();
        $config->setApiKey("Authorization", $strAuthenticationJWT);
        $config->setApiKeyPrefix("Authorization", "Bearer");

        if(!is_null($this->_credentials->getHost()))
        {
            $config->setHost($this->_credentials->getHost());
        }

        parent::__construct(
            new \GuzzleHttp\Client(array(
                "connect_timeout" => $connectTimeoutSeconds,
                "timeout" => $requestTimeoutSeconds
            )),
            $config
        );
    }

    protected function _apiClientAuthenticate($login, $password, $role, $host)
    {
        $config = new Configuration();

        if(!is_null($host))
        {
            $config->setHost($host);
        }

        $authApiInstance = new Api\LumminaryAPISpecApi(
            new \GuzzleHttp\Client(array(
                "connect_timeout" => LumminaryApi::CONNECT_TIMEOUT_S,
                "timeout" => LumminaryApi::REQUEST_TIMEOUT_S
            )),
            $config
        );

        $authResult = $authApiInstance->postJwtAuth($login, $password, $role);

        if(is_null($authResult))
        {
            throw new ApiException("Unexpected null jwt token but status 200 OK when authenticating");
        }
        
        return $authResult["accessToken"];
    }

    public function getCredentials()
    {
        return $this->_credentials;
    }

    /**
     * @Override
     */
    public function postClientSnpGroup($client_id, $dataset_id, $snps, $x_fields = null)
    {
        $snpsEncoded = json_encode(
            array(
                "snps" => $snps
            )
        );

        return parent::postClientSnpGroup($client_id, $dataset_id, $snpsEncoded, $x_fields);
    }

    public function authorizationMetadata($authorizationUuid)
    {
        $authorization = $this->getProductAuthorization($this->_credentials->getLogin(), $authorizationUuid);

        $authorizationMetadata = array(
            "customer" => $authorization["clientUuid"],
            "product" => $authorization["productUuid"],
            "authorization" => $authorization["authorizationUuid"],
            "created_timestamp_utc" => $authorization["createTimestamp"]
        );

        if(!is_null($authorization["scopes"]["dataset"]))
        {
            $authorizationMetadata["dataset"] = $authorization["scopes"]["dataset"];
        }
        if(!is_null($authorization["scopes"]["email"]))
        {
            $authorizationMetadata["customer_email"] = $authorization["scopes"]["email"];
        }
        if(!is_null($authorization["scopes"]["name"]))
        {
            $authorizationMetadata["customer_name"] = array(
                "first_name" => $authorization["scopes"]["name"]["firstName"],
                "last_name" => $authorization["scopes"]["name"]["lastName"]
            );
        }
        if(!is_null($authorization["scopes"]["address"]))
        {
            $authorizationMetadata["customer_address"] = array(
                "city" => $authorization["scopes"]["address"]["city"],
                "country" => $authorization["scopes"]["address"]["country"],
                "address1" => $authorization["scopes"]["address"]["address1"],
                "address2" => $authorization["scopes"]["address"]["address2"],
                "zipcode" => $authorization["scopes"]["address"]["zipcode"],
                "state" => $authorization["scopes"]["address"]["state"],
            );
        }

        return $authorizationMetadata;
    }

    public function authorizationDnaData($authorizationUuid)
    {
        $authorization = $this->getProductAuthorization($this->_credentials->getLogin(), $authorizationUuid);

        if(!is_null($authorization["scopes"]["dataset"]))
        {
            $authorizationData = array();

            $datasetSnps = $this->getClientSnpGroup($authorization["clientUuid"], $authorization["scopes"]["dataset"]);

            $snpRows = array();
            $snpRows[] = "# rsid\tchromosome\tposition\tgenotype";

            foreach($datasetSnps as $snp)
            {
                $chromosome = LumminaryApi::chromosome_common_symbol($snp["chromosomeAccession"]);
                $variantLine = array($snp["snpId"], $chromosome, $snp["location"], implode("", $snp["genotypedAlleles"]));

                $snpRows[] = implode("\t", $variantLine);
            }
            
            return $snpRows;
        }
        else
        {
            return null;
        }
    }

    public static function cwl_callback_payload_extract($callbackUrl, $partnerEncryptionKey, $jsonDecodePayload = true)
    {
        $query = parse_url($callbackUrl, PHP_URL_QUERY);
        parse_str($query, $queryParams);
        
        $decryptedData = array();
        foreach($queryParams as $paramName => $paramValue)
        {
            $valueDecrypted = LumminaryApi::cwl_decrypt($paramValue, $partnerEncryptionKey);

            if($jsonDecodePayload)
            {
                $decryptedData[$paramName] = json_decode($valueDecrypted, true);
            }
            else
            {
                $decryptedData[$paramName] = $valueDecrypted;
            } 
        }

        return $decryptedData;
    }

    public static function cwl_decrypt($dataEncrypted, $partnerEncryptionKey)
    {
        $encryptionKey = base64_decode($partnerEncryptionKey);
        $dataEncrypted = base64_decode($dataEncrypted);

        $ivLength = openssl_cipher_iv_length(LumminaryApi::CWL_ENCRYPTION_METHOD);
        $iv = substr($dataEncrypted, 0, $ivLength);
        
        $tag = substr($dataEncrypted, -1 * LumminaryApi::MAC_LENGTH_BYTES);
        $ciphertext = substr($dataEncrypted, $ivLength, -1 * LumminaryApi::MAC_LENGTH_BYTES);
        
        $dataDecrypted = openssl_decrypt($ciphertext, LumminaryApi::CWL_ENCRYPTION_METHOD, $encryptionKey, OPENSSL_RAW_DATA, $iv, $tag);

        if($dataDecrypted)
        {
            return $dataDecrypted;
        }
        else
        {
            throw new ApiException("Unable to decrypt ".$dataEncrypted.", MAC verification failed");
        }
    }

    public static function cwl_encrypt($dataDecrypted, $partnerEncryptionKey)
    {
        $partnerEncryptionKey = base64_decode($partnerEncryptionKey);

        $ivLength = openssl_cipher_iv_length(LumminaryApi::CWL_ENCRYPTION_METHOD);
        $iv = openssl_random_pseudo_bytes($ivLength);

        $tag = null;
        $dataEncrypted = openssl_encrypt(
            $dataDecrypted,
            LumminaryApi::CWL_ENCRYPTION_METHOD,
            $partnerEncryptionKey,
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
            '', //$aad
            LumminaryAPI::MAC_LENGTH_BYTES //$tag_length 
        );
        if (strlen($tag) != LumminaryApi::MAC_LENGTH_BYTES) {
            throw new ApiException("Unexpected tag size " . strlen($tag) . " bytes, expecting " . LumminaryApi::MAC_LENGTH_BYTES . " bytes");
        }

        $objEncryptedData = array(
            "iv" => $iv,
            "ciphertext" => $dataEncrypted,
            "tag" => $tag
        );

        return $objEncryptedData;
    }

    public static function cwl_data_request_build($dataDecrypted, $partnerEncryptionKey, $jsonEncodePayload = true)
    {
        if($jsonEncodePayload)
        {
            $dataDecrypted = json_encode($dataDecrypted);
        }
        $objEncryptedData = LumminaryApi::cwl_encrypt($dataDecrypted, $partnerEncryptionKey);

        $payloadEncrypted = base64_encode($objEncryptedData["iv"] . $objEncryptedData["ciphertext"] . $objEncryptedData["tag"]);

        return $payloadEncrypted;
    }

    public static function chromosome_common_symbol($chromosomeAccession)
    {
        preg_match_all("/NC_(0)+(.*)/", $chromosomeAccession, $matches);
        $accessionNumber = intval($matches[2][0]);

        if($accessionNumber < 23)
        {
            return (string)$accessionNumber;
        }
        elseif ($accessionNumber == 24)
        {
            return "Y";
        }
        elseif ($accessionNumber == 23)
        {
            return "X";
        }
        elseif ($accessionNumber == 12920)
        {
            return "MT";
        }
        else
        {
            throw new ApiException("Invalid chromosome accession ".$chromosomeAccession);
        }
    }
}
