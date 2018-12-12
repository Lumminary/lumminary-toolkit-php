<?php
require_once(__DIR__."/vendor/autoload.php");

$logger = new \Monolog\Logger("lumminary-toolkit");
$logger->pushHandler(new \Monolog\Handler\StreamHandler('php://stdout'));

$commandParams = new Commando\Command();
$commandParams->option("config-path")
    ->require(true)
    ->describeAs("Path to the json config for the Lumminary toolkit");
try
{
    $configParser = new AppToolkit\Config($commandParams["config-path"]);
    $objConfig = $configParser->parse();

    $logger->info("Connecting to the Lumminary api on ".$objConfig["api_host"]." as product ".$objConfig["product_uuid"]);
    $credentials = new \Lumminary\Client\Credentials(
        /*login*/ $objConfig["product_uuid"],
        /*password*/ $objConfig["api_key"],
        /*host*/ $objConfig["api_host"],
        /*role*/ "role_product"
    );
    $apiClient = new \Lumminary\Client\LumminaryApi($credentials);
    $logger->info("Authenticated to the Lumminary api");

    $authorizationsPending = $apiClient->getAuthorizationsQueue($objConfig["product_uuid"]);
    $logger->info("Fetched ".count($authorizationsPending)." authorizations");

    $exportHandlerClass = AppToolkit\Config::get_export_handler_class($objConfig["export_handler"]);
    $product = $apiClient->getProduct($objConfig["product_uuid"]);
    foreach($authorizationsPending as $authorization)
    {
        try
        {
            $exportHandler = new $exportHandlerClass($objConfig["output_root"], $authorization, $product, $apiClient, $objConfig["optional"]);
            if(!$exportHandler->shouldPullAuthorization())
            {
                $logger->info("Skipping authorization ".$authorization["authorizationUuid"]." because Authorization data directory already exists");
                continue;
            }
            else
            {
                $logger->info("Processing authorization ".$authorization["authorizationUuid"]);

                $exportHandler->pullAuthorizationData();
                $exportHandler->updateAuthorizationProcessed();
            }
        }
        catch(\Throwable $pullAuthorizationDataError)
        {
            if($pullAuthorizationDataError->getCode() == 401)
            {
                $logger->error("Unable to pull data for authorization ".$authorization["authorizationUuid"].". UNAUTHORIZED");
            }
            else
            {
                $logger->error($pullAuthorizationDataError);
            }
        }
    }
}
catch(AppToolkit\ToolkitException $parseException)
{
    $logger->error($parseException->getMessage());
}
