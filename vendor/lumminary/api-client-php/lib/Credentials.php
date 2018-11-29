<?php
namespace Lumminary\Client;

use Lumminary\Client\ApiException;

class Credentials
{
    const API_ENDPOINT = "api.lumminary.com";
    const ROLE_PRODUCT = "role_product";

    /**
     * The Client email / ProductID to authenticate as
     *
     * @var string
     */
    protected $login;

    /**
     * The Client password / Product API key to authenticate with
     *
     * @var string
     */
    protected $password;

    /**
     * The role to authenticate under. Either role_client or role_product
     *
     * @var string
     */
    protected $role;
    
    /**
     * The host to which API calls will be made.
     * Can either be the production or test environment
     *
     * @var string
     */
    protected $host;
    
    function __construct($login = null, $password = null, $host = Credentials::API_ENDPOINT, $role = Credentials::ROLE_PRODUCT)
    {
        $this->login = $login;
        $this->password = $password;
        $this->role = $role;
        $this->host = $host;
    }

    /**
     * Loads credentials saved in the JSON file passed as a parameter
     * If a key was present in the constructor, then it can be omitted from the config file
     * 
     * @param   string  $credentialsFilePath    The path of the file containing the credentials, in JSON format
     * 
     * @return  null
     */
    public function loadJSONCredentials($credentialsFilePath)
    {
        if(!file_exists($credentialsFilePath))
        {
            throw new ApiException("No config file found at ".$credentialsFilePath);
        }

        $fileContents = file_get_contents($credentialsFilePath);
        $config = json_decode($fileContents, /*bAssoc*/ true);
        if(is_null($config))
        {
            throw new ApiException("Unable to decode JSON at ".$credentialsFilePath);
        }

        if(array_key_exists('login', $config))
        {
            $this->login = $config['login'];
        }
        else
        {
            if(is_none($this->login))
            {
                throw new ApiException("Missing 'login' key from credentials at ".$credentialsFilePath);
            }
        }
        if(array_key_exists('api_key', $config))
        {
            $this->password = $config['api_key'];
        }
        else
        {
            if(is_none($this->password))
            {
                throw new ApiException("Missing 'api_key' key from credentials at ".$credentialsFilePath);
            }
        }
        if(array_key_exists('role', $config))
        {
            $this->role = $config['role'];
        }
        else
        {
            if(is_none($this->role))
            {
                throw new ApiException("Missing 'role' key from credentials at ".$credentialsFilePath);
            }
        }
        if(array_key_exists('host', $config))
        {
            $this->host = $config['host'];
        }
        else
        {
            if(is_none($this->host))
            {
                throw new ApiException("Missing 'host' key from credentials at ".$credentialsFilePath);
            }
        }
    }


    public function getLogin()
    {
        return $this->login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getHost()
    {
        return $this->host;
    }
}
