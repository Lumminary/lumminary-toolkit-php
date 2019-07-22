<?php

use AppToolkit\ToolkitException;
require_once(__DIR__."/vendor/autoload.php");

function rrmdir($dirPath)
{
    if(!is_dir($dirPath))
    {
        throw new ToolkitException($dirPath." is not a directory");
    }

    foreach(scandir($dirPath) as $dirChild)
    {
        if(in_array($dirChild, [".", ".."]))
        {
            continue;
        }


        $childPath = $dirPath."/".$dirChild;

        if(is_dir($childPath))
        {
            rrmdir($childPath);
        }
        elseif(is_file($childPath))
        {
            $bSuccess = unlink($childPath);
            if(!$bSuccess)
            {
                throw new ToolkitException("Unable to remove file ".$childPath);
            }
        }
        else
        {
            throw new ToolkitException("Unexpected file type for ".$childPath);
        }
    }

    $bSuccess = rmdir($dirPath);
    if(!$bSuccess)
    {
        throw new ToolkitException("Unable to remove directory ".$childPath);
    }
}

function post_reports($authorizationUuid, $productUuid, $authorizationReportsBasePath, $authorizationBasePath, $logger, $apiClient)
{
    if(!is_dir($authorizationReportsBasePath))
    {
        throw new \Exception("No reports for authorization ".$authorizationUuid." at ".$authorizationReportsBasePath);
    }

    $reportsCreated = [];
    $resultFilePath = $authorizationReportsBasePath."/result.json";

    if(is_file($resultFilePath))
    {
        // Upload report credentials/unfulfillable/dispatched
        $objResult = json_decode(file_get_contents($resultFilePath), true);

        if(array_key_exists("credentials", $objResult))
        {
            $logger->info("Uploading credentials for authorization ".$authorizationUuid);

            if(array_key_exists("url", $objResult["credentials"]))
            {
                $reportsCreated[] = $apiClient->postAuthorizationResultCredentials(
                    $productUuid,
                    $authorizationUuid,
                    $objResult["credentials"]["url"],
                    $objResult["credentials"]["username"],
                    $objResult["credentials"]["password"]
                );
            }
            else
            {
                throw new \ToolkitException("Expected required 'url' attribute in the 'credentials' object at ".$resultFilePath);
            }
        }
        elseif(array_key_exists("physical_product", $objResult))
        {
            $logger->info("Uploading order dispatched report for authorization ".$authorizationUuid);

            if(array_key_exists("physical_product_completed", $objResult["physical_product"]) && $objResult["physical_product"]["physical_product_completed"])
            {
                $reportsCreated[] = $apiClient->postProductAuthorization(
                    $productUuid,
                    $authorizationUuid
                );
            }
            else
            {
                throw new \ToolkitException("Expecting 'physical_product_completed' attribute under 'physical_product' in ".$resultFilePath);
            }
        }
        elseif(array_key_exists("unfulfillable", $objResult))
        {
            $logger->info("Uploading error report for authorization ".$authorizationUuid);

            if(array_key_exists("error", $objResult["unfulfillable"]))
            {
                $reportsCreated[] = $apiClient->postProductAuthorizationUnfulfillable($productUuid, $authorizationUuid);
            }
            else
            {
                throw new \ToolkitException("Expecting 'error' attribute under 'unfulfillable' in ".$resultFilePath);
            }
        }
        else
        {
            throw new \ToolkitException("Unexpected reports object format ".json_encode($objResult)." in ".$resultFilePath);
        }
    }
    else
    {
        $authorizationReportFiles = scandir($authorizationReportsBasePath);
        $logger->info("Uploading ".(count($authorizationReportFiles) - 2)." report files for authorization ".$authorizationUuid);

        foreach($authorizationReportFiles as $reportFilename)
        {
            if(in_array($reportFilename, [".", ".."]))
            {
                continue;
            }

            $reportPath = $authorizationReportsBasePath."/".$reportFilename;

            $reportFile = new \SplFileObject($reportPath);
            $reportsCreated[] = $apiClient->postAuthorizationResultFile($productUuid, $authorizationUuid, $reportFile, $reportFilename);
        }
    }

    $logger->info("Done uploading reports for authorization ".$authorizationUuid.", cleaning up authorization directory");
    try
    {
        rrmdir($authorizationBasePath);
    }
    catch(\Throwable $authorizationCleanupException)
    {
        throw new ToolkitException("Unable to cleanup authorization ".$authorizationUuid.". ".$authorizationCleanupException->getMessage());
    }

    return $reportsCreated;
}

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


    $exportHandlerClass = AppToolkit\Config::get_export_handler_class($objConfig["export_handler"]);
    $product = $apiClient->getProduct($objConfig["product_uuid"]);

    if(in_array("push_reports", $objConfig["operations"]))
    {
        foreach(scandir($objConfig["output_root"]) as $authorizationUuid)
        {
            try
            {
                if(in_array($authorizationUuid, [".", ".."]))
                {
                    continue;
                }

                $authorizationBasePath = $objConfig["output_root"]."/".$authorizationUuid;
                $authorizationReportsBasePath = $authorizationBasePath."/reports";

                $arrReportsCreated = post_reports($authorizationUuid, $objConfig["product_uuid"], $authorizationReportsBasePath, $authorizationBasePath, $logger, $apiClient);
            }
            catch(\Throwable $uploadReportError)
            {
                $logger->error($uploadReportError->getMessage());
            }
        }
    }

    if(in_array("pull_datasets", $objConfig["operations"]))
    {
        $authorizationsPending = $apiClient->getAuthorizationsQueue($objConfig["product_uuid"]);
        $logger->info("Fetched ".count($authorizationsPending)." authorizations");
        foreach($authorizationsPending as $authorization)
        {
            try
            {
                $exportHandler = new $exportHandlerClass($objConfig, $authorization, $product, $apiClient);
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
                    $logger->error($pullAuthorizationDataError->getMessage());
                }
            }
        }
    }
}
catch(ToolkitException $parseException)
{
    $logger->error($parseException->getMessage());
}
