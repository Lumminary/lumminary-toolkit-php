<?php namespace AppToolkit\ExportHandler;

abstract class ExportHandlerBase
{
    protected $_config = null;
    protected $_authorization = null;
    protected $_product = null;
    protected $_api = null;
    protected $_path = null;

    public function __construct($config, $authorization, $product, $api)
    {
        $this->_config = $config;
        $this->_authorization = $authorization;
        $this->_product = $product;
        $this->_api = $api;

        $this->_path = $this->_config["output_root"]."/".$this->_authorization["authorizationUuid"];
    }

    public function shouldPullAuthorization()
    {
        if(is_dir($this->_path))
        {
            return false;
        }

        return true;
    }

    public function pullAuthorizationData()
    {
        if(is_dir($this->_path) && count(scandir($this->_path)) != 2)
        {
            throw new \AppToolkit\ToolkitException(
                "Unable to fetch authorization ".$this->_authorization["authorizationUuid"].", directory ".$this->_path." already exists and is not empty"
            );
        }

        if(!is_dir($this->_path))
        {
            mkdir($this->_path);
        }

        $authorizationMetadataPath = $this->_saveAuthorization();
        $dnaDataPath = $this->_saveDataset();

        $objAuthorizationData = array(
            "authorization_metadata_path" => $authorizationMetadataPath,
            "authorization_dna_data_path" => $dnaDataPath
        );

        return $objAuthorizationData;
    }

    public static function get_config_optional_schema()
    {
        return array();
    }

    abstract protected function _saveDataset();
    abstract protected function _saveAuthorization();
    abstract protected function _authorizationMetadataPath();
    abstract protected function _dnaDataPath();
    abstract public function updateAuthorizationProcessed();
}
