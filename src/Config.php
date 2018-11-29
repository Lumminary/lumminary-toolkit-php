<?php namespace AppToolkit;

class Config
{
    private $_path = null;

    public function __construct($path)
    {
        $this->_path = $path;
        $this->_configExplicit = $this->_extract();
        $this->_clsCustomHandler = Config::get_export_handler_class($this->_configExplicit["export_handler"]);
    }

    public function parse()
    {
        $configExplicit = $this->_fillDefaults($this->_configExplicit);
        $this->_assertConfigValid($configExplicit);

        return $configExplicit;
    }

    public static function get_export_handler_class($exportHandler)
    {
        $exportHandlerNamespaced = "AppToolkit\\ExportHandler\\".$exportHandler;

        return $exportHandlerNamespaced;
    }

    private function _extract()
    {
        if(!is_file($this->_path))
        {
            throw new ToolkitException("No file found at ".$this->_path." expecting a configuration json");
        }

        $configContents = file_get_contents($this->_path);
        $configExplicit = json_decode($configContents, /*bAssoc*/ true);

        return $configExplicit;
    }

    private function _fillDefaults($configExplicit, $configSchema = null)
    {
        if(is_null($configSchema))
        {
            $configSchema = $this->_getConfigSchema();
        }

        foreach($configSchema as $attributeName => $attributeSchema)
        {
            if(!array_key_exists($attributeName, $configExplicit))
            {
                if(!array_key_exists("required", $attributeSchema) || $attributeSchema["required"])
                {
                    throw new ToolkitException("Expecting attribute ".$attributeName." in ".$this->_path);
                }

                if(!array_key_exists("default", $attributeSchema))
                {
                    throw new ToolkitException("Attribute ".$attributeName." does not have a default value and was not provided explicitly in ".$this->_path);
                }

                $configExplicit[$attributeName] = $attributeSchema["default"];
            }
        }

        if(array_key_exists("optional", $configSchema))
        {
            $configExplicit["optional"] = $this->_fillDefaults($configExplicit["optional"], $configSchema["optional"]);
        }

        return $configExplicit;
    }

    private function _assertConfigValid($configWithDefaults)
    {
        $configSchema = $this->_getConfigSchema();

        $configOptionalSchema = $configSchema["optional"];
        unset($configSchema["optional"]);

        $configOptional = $configWithDefaults["optional"];
        unset($configWithDefaults["optional"]);

        foreach($configSchema as $attributeName => $attributeSchema)
        {
            $configValue = $configWithDefaults[$attributeName];
            $attributeSchema["validator"]($configValue);
        }
        foreach($configOptionalSchema as $attributeName => $attributeSchema)
        {
            $configValue = $configOptional[$attributeName];
            $attributeSchema["validator"]($configValue);
        }
    }

    private function _getConfigSchema()
    {
        return array(
            "api_key" => array(
                "validator" => function($apiKey){
                    Config::_validate_api_key($apiKey);
                },
                "required" => True
            ),
            "product_uuid" => array(
                "validator" => function($productUuid){
                    Config::_validate_product_uuid($productUuid);
                },
                "required" => True
            ),
            "api_host" => array(
                "validator" => function($apiHost){
                    Config::_validate_api_host($apiHost);
                },
                "required" => False,
                "default" => "https://api.lumminary.com/v1"
            ),
            "output_root" => array(
                "validator" => function($outputRoot){
                    Config::_validate_output_root($outputRoot);
                },
                "required" => True
            ),
            "export_handler" => array(
                "validator" => function($exportHandler){
                    Config::_validate_export_handler($exportHandler);
                },
                "required" => True
            ),
            "optional" => $this->_clsCustomHandler::get_config_optional_schema()
        );
    }

    private static function _validate_api_key($apiKey)
    {
        if (base64_encode(base64_decode($apiKey, true)) !== $apiKey)
        {
            throw new ToolkitException("Invalid api key ".$apiKey." Expecting a base-64 encoded string");
        }
    }

    private static function _validate_product_uuid($productUuid)
    {
        if(!preg_match("/[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}/", $productUuid))
        {
            throw new ToolkitException("Invalid value for attribute `product_uuid`");
        }
    }

    private static function _validate_api_host($apiHost)
    {
        if(!preg_match("/^https:\/\/(.)*\.lumminary\.com\/v[0-9]+$/", $apiHost))
        {
            throw new ToolkitException("Invalid value for attribute `api_host`");
        }
    }

    private static function _validate_output_root($outputRoot)
    {
        if(!is_dir($outputRoot))
        {
            throw new ToolkitException("Invalid value ".$outputRoot." for attribute `output_root` Expecting a directory");
        }
    }

    private static function _validate_export_handler($exportHandler)
    {
        $exportHandlersAvailable = array();
        $filesToSkip = array(".", "..", "ExportHandlerBase.php");

        foreach(scandir(__DIR__."/ExportHandler") as $fileName)
        {
            $filePath = __DIR__."/ExportHandler/".$fileName;

            if(in_array($fileName, $filesToSkip) || is_dir($filePath))
            {
                continue;
            }

            if(!preg_match("/^ExportHandler(.)*\.php$/", $fileName))
            {
                throw new ToolkitException("Unexpected export handler filename ".$fileName);
            }

            $exportHandlersAvailable[] = preg_replace("/\.php$/", '', $fileName);
        }

        if(!is_file(__DIR__."/ExportHandler/".$exportHandler.".php"))
        {
            throw new ToolkitException("Invalid export handler ".$exportHandler." expected one of : ".implode(",", $exportHandlersAvailable));
        }
    }
}
