<?php namespace AppToolkit\ExportHandler;

class ExportHandlerTSV extends ExportHandlerBase
{
    public function __construct($outputRoot, $authorization, $product, $api, $optional = null)
    {
        parent::__construct($outputRoot, $authorization, $product, $api, $optional);
    }

    protected function _saveDataset()
    {
        $datasetPath = $this->_dnaDataPath();

        $dnaData = $this->_api->authorizationDNAData($this->_authorization["authorizationUuid"]);
        file_put_contents($datasetPath, implode("\n", $dnaData));

        return $datasetPath;
    }

    protected function _saveAuthorization()
    {
        $authorizationPath = $this->_authorizationMetadataPath();

        $authorizationMetadata = $this->_api->authorizationMetadata($this->_authorization["authorizationUuid"]);
        file_put_contents($authorizationPath, json_encode($authorizationMetadata, JSON_PRETTY_PRINT));

        return $authorizationPath;
    }

    public function updateAuthorizationProcessed()
    {
        $this->_api->postProductAuthorization($this->_product["productUuid"], $this->_authorization["authorizationUuid"]);
    }

    protected function _authorizationMetadataPath()
    {
        return $this->_path."/".$this->_optional["authorization-metadata-filename"];
    }

    protected function _dnaDataPath()
    {
        return $this->_path."/".$this->_optional["dna-data-filename"];
    }

    public static function get_config_optional_schema()
    {
        return array(
            "dna-data-filename" => array(
                "validator" => function($dnaDataFilename){
                    ExportHandlerTSV::_validate_dna_data_filename($dnaDataFilename);
                },
                "required" => false,
                "default" => "dna-data.tsv"
            ),
            "authorization-metadata-filename" => array(
                "validator" => function($authorizationMetadata){
                    ExportHandlerTSV::_validate_authorization_metadata($authorizationMetadata);
                },
                "required" => false,
                "default" => "authorization-metadata.json"
            )
        );
    }

    private static function _validate_dna_data_filename($dnaDataFilename)
    {
        return;
    }

    private static function _validate_authorization_metadata($authorizationMetadata)
    {
        return;
    }
}
