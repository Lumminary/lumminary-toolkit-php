<?php namespace AppToolkit\ExportHandler;

class ExportHandlerTSV extends ExportHandlerBase
{
    protected function _saveDataset()
    {
        $datasetPath = $this->_dnaDataPath();

        $dnaData = $this->_api->authorizationDNAData($this->_authorization["authorizationUuid"]);

        $tmpDatasetPath = $datasetPath."_tmp";
        file_put_contents($tmpDatasetPath, implode("\n", $dnaData));
        rename($tmpDatasetPath, $datasetPath);

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
        // Do nothing for plain TSV export, to allow for time to process the authorized dataset
        return;
    }

    protected function _authorizationMetadataPath()
    {
        return $this->_path."/".$this->_config["optional"]["authorization_metadata_filename"];
    }

    protected function _dnaDataPath()
    {
        $datasetFilename = null;
        if(!is_null($this->_config["optional"]["dna_data_filename"]))
        {
            $datasetFilename = $this->_config["optional"]["dna_data_filename"];
        }
        else
        {
            $authorizationMetadata = $this->_api->authorizationMetadata($this->_authorization["authorizationUuid"]);
            $datasetFilename = $authorizationMetadata["dataset"];
        }

        return $this->_path."/".$datasetFilename;
    }

    public static function get_config_optional_schema()
    {
        return array(
            "dna_data_filename" => array(
                "validator" => function($dnaDataFilename){
                    ExportHandlerTSV::_validate_dna_data_filename($dnaDataFilename);
                },
                "required" => false,
                "default" => null
            ),
            "authorization_metadata_filename" => array(
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
