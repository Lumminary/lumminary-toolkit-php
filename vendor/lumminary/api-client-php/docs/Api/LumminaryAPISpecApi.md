# Lumminary\Client\LumminaryAPISpecApi

All URIs are relative to *https://api.lumminary.com/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getAuthorizationsQueue**](LumminaryAPISpecApi.md#getAuthorizationsQueue) | **GET** /products/{productId}/authorizations | 
[**getClientGene**](LumminaryAPISpecApi.md#getClientGene) | **GET** /clients/{clientId}/datasets/{datasetId}/genes/{geneSymbol} | Get gene by symbol
[**getClientSnp**](LumminaryAPISpecApi.md#getClientSnp) | **GET** /clients/{clientId}/datasets/{datasetId}/snps/{snpId} | Get SNP information
[**getClientSnpGroup**](LumminaryAPISpecApi.md#getClientSnpGroup) | **GET** /clients/{clientId}/datasets/{datasetId}/snps/ | 
[**getGene**](LumminaryAPISpecApi.md#getGene) | **GET** /reference/genes/databases/{databaseName}/accessions/{accession} | Generic gene information
[**getProduct**](LumminaryAPISpecApi.md#getProduct) | **GET** /products/{productId} | Get product details
[**getProductAuthorization**](LumminaryAPISpecApi.md#getProductAuthorization) | **GET** /products/{productId}/authorizations/{authorizationId} | 
[**getReferenceChromosome**](LumminaryAPISpecApi.md#getReferenceChromosome) | **GET** /reference/genomes/{genomeBuildAccession}/chromosomes/{chromosomeAccession} | Sequence for a region of the reference genome
[**getReferenceGenome**](LumminaryAPISpecApi.md#getReferenceGenome) | **GET** /reference/genomes/{genomeBuildAccession}/chromosomes | Reference genome metadata
[**getReferenceGenomesGroup**](LumminaryAPISpecApi.md#getReferenceGenomesGroup) | **GET** /reference/genomes/ | Reference genome builds
[**getReferenceSnp**](LumminaryAPISpecApi.md#getReferenceSnp) | **GET** /reference/snps/{snpAccession} | Reference SNP data
[**postAuthorizationResultCredentials**](LumminaryAPISpecApi.md#postAuthorizationResultCredentials) | **POST** /products/{productId}/authorizations/{authorizationId}/credentials | Provide a result for the authorization
[**postAuthorizationResultFile**](LumminaryAPISpecApi.md#postAuthorizationResultFile) | **POST** /products/{productId}/authorizations/{authorizationId}/file | Provide a file result to the authorization, e
[**postClientSnpGroup**](LumminaryAPISpecApi.md#postClientSnpGroup) | **POST** /clients/{clientId}/datasets/{datasetId}/snps/ | Get a large group of SNPs
[**postJwtAuth**](LumminaryAPISpecApi.md#postJwtAuth) | **POST** /auth/jwt | General-purpose authentication
[**postProductAuthorization**](LumminaryAPISpecApi.md#postProductAuthorization) | **POST** /products/{productId}/authorizations/{authorizationId} | Signal that processing is complete, without uploading any result
[**postProductAuthorizationUnfulfillable**](LumminaryAPISpecApi.md#postProductAuthorizationUnfulfillable) | **POST** /products/{productId}/authorizations/{authorizationId}/unfulfillable | Catch-all Authorization state, for authorizations that passed all verifications and should reach the partner Product, but cannot be fulfilled for various reasons


# **getAuthorizationsQueue**
> \Lumminary\Client\Models\Authorization[] getAuthorizationsQueue($productId, $seqNumStart, $xFields)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: Bearer
$config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$apiInstance = new Lumminary\Client\Api\LumminaryAPISpecApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$productId = "productId_example"; // string | The UUID of the product
$seqNumStart = "seqNumStart_example"; // string | The first sequence number from which to fetch (the sequence number of the last processed authorization)
$xFields = "xFields_example"; // string | An optional fields mask

try {
    $result = $apiInstance->getAuthorizationsQueue($productId, $seqNumStart, $xFields);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LumminaryAPISpecApi->getAuthorizationsQueue: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **productId** | **string**| The UUID of the product |
 **seqNumStart** | **string**| The first sequence number from which to fetch (the sequence number of the last processed authorization) | [optional]
 **xFields** | **string**| An optional fields mask | [optional]

### Return type

[**\Lumminary\Client\Models\Authorization[]**](../Model/Authorization.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getClientGene**
> \Lumminary\Client\Models\ClientGene getClientGene($clientId, $datasetId, $geneSymbol, $xFields)

Get gene by symbol

Gets A gene by its symbol, which can be found by querying the reference/ resource.  Will return a 404 if a gene exists as a reference, but its genomic coordinates intersect no SNPs in the dataset

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: Bearer
$config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$apiInstance = new Lumminary\Client\Api\LumminaryAPISpecApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$clientId = "clientId_example"; // string | The UUID of the client
$datasetId = "datasetId_example"; // string | The UUID of one of the client's dataset
$geneSymbol = "geneSymbol_example"; // string | The symbol of a gene to be fetched
$xFields = "xFields_example"; // string | An optional fields mask

try {
    $result = $apiInstance->getClientGene($clientId, $datasetId, $geneSymbol, $xFields);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LumminaryAPISpecApi->getClientGene: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **clientId** | **string**| The UUID of the client |
 **datasetId** | **string**| The UUID of one of the client&#39;s dataset |
 **geneSymbol** | **string**| The symbol of a gene to be fetched |
 **xFields** | **string**| An optional fields mask | [optional]

### Return type

[**\Lumminary\Client\Models\ClientGene**](../Model/ClientGene.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getClientSnp**
> \Lumminary\Client\Models\ClientSNP getClientSnp($clientId, $datasetId, $snpId, $xFields)

Get SNP information

Gets SNP information, as provided by the dataset.  If fetching this as an product, the client must have already granted access to the snip (see the 'products' group)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: Bearer
$config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$apiInstance = new Lumminary\Client\Api\LumminaryAPISpecApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$clientId = "clientId_example"; // string | The UUID of the client
$datasetId = "datasetId_example"; // string | The UUID of one of the client's dataset
$snpId = "snpId_example"; // string | The rsId of a SNP to be fetched
$xFields = "xFields_example"; // string | An optional fields mask

try {
    $result = $apiInstance->getClientSnp($clientId, $datasetId, $snpId, $xFields);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LumminaryAPISpecApi->getClientSnp: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **clientId** | **string**| The UUID of the client |
 **datasetId** | **string**| The UUID of one of the client&#39;s dataset |
 **snpId** | **string**| The rsId of a SNP to be fetched |
 **xFields** | **string**| An optional fields mask | [optional]

### Return type

[**\Lumminary\Client\Models\ClientSNP**](../Model/ClientSNP.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getClientSnpGroup**
> \Lumminary\Client\Models\ClientSNP[] getClientSnpGroup($clientId, $datasetId, $xFields)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: Bearer
$config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$apiInstance = new Lumminary\Client\Api\LumminaryAPISpecApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$clientId = "clientId_example"; // string | The UUID of the client
$datasetId = "datasetId_example"; // string | The UUID of one of the client's dataset
$xFields = "xFields_example"; // string | An optional fields mask

try {
    $result = $apiInstance->getClientSnpGroup($clientId, $datasetId, $xFields);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LumminaryAPISpecApi->getClientSnpGroup: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **clientId** | **string**| The UUID of the client |
 **datasetId** | **string**| The UUID of one of the client&#39;s dataset |
 **xFields** | **string**| An optional fields mask | [optional]

### Return type

[**\Lumminary\Client\Models\ClientSNP[]**](../Model/ClientSNP.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getGene**
> \Lumminary\Client\Models\PublicGene getGene($databaseName, $accession, $dbsnpBuild, $referenceGenome, $xFields)

Generic gene information

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: Bearer
$config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$apiInstance = new Lumminary\Client\Api\LumminaryAPISpecApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$databaseName = "databaseName_example"; // string | The name of the database to search. E.g: Genbank
$accession = "accession_example"; // string | The accession within the selected database
$dbsnpBuild = 149; // int | The dbSNP build for which to consider snps belonging to the gene. Defaults to 149
$referenceGenome = "GRCH37P13"; // string | The reference genome for which gene annotations will be returned. Defaults to GRCh37p13
$xFields = "xFields_example"; // string | An optional fields mask

try {
    $result = $apiInstance->getGene($databaseName, $accession, $dbsnpBuild, $referenceGenome, $xFields);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LumminaryAPISpecApi->getGene: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **databaseName** | **string**| The name of the database to search. E.g: Genbank |
 **accession** | **string**| The accession within the selected database |
 **dbsnpBuild** | **int**| The dbSNP build for which to consider snps belonging to the gene. Defaults to 149 | [optional] [default to 149]
 **referenceGenome** | **string**| The reference genome for which gene annotations will be returned. Defaults to GRCh37p13 | [optional] [default to GRCH37P13]
 **xFields** | **string**| An optional fields mask | [optional]

### Return type

[**\Lumminary\Client\Models\PublicGene**](../Model/PublicGene.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getProduct**
> \Lumminary\Client\Models\Product getProduct($productId, $xFields)

Get product details

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: Bearer
$config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$apiInstance = new Lumminary\Client\Api\LumminaryAPISpecApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$productId = "productId_example"; // string | The UUID of the product
$xFields = "xFields_example"; // string | An optional fields mask

try {
    $result = $apiInstance->getProduct($productId, $xFields);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LumminaryAPISpecApi->getProduct: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **productId** | **string**| The UUID of the product |
 **xFields** | **string**| An optional fields mask | [optional]

### Return type

[**\Lumminary\Client\Models\Product**](../Model/Product.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getProductAuthorization**
> \Lumminary\Client\Models\Authorization getProductAuthorization($productId, $authorizationId, $xFields)



### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: Bearer
$config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$apiInstance = new Lumminary\Client\Api\LumminaryAPISpecApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$productId = "productId_example"; // string | The UUID of the product
$authorizationId = "authorizationId_example"; // string | The UUID of the authorization
$xFields = "xFields_example"; // string | An optional fields mask

try {
    $result = $apiInstance->getProductAuthorization($productId, $authorizationId, $xFields);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LumminaryAPISpecApi->getProductAuthorization: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **productId** | **string**| The UUID of the product |
 **authorizationId** | **string**| The UUID of the authorization |
 **xFields** | **string**| An optional fields mask | [optional]

### Return type

[**\Lumminary\Client\Models\Authorization**](../Model/Authorization.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getReferenceChromosome**
> \Lumminary\Client\Models\ReferenceSequence getReferenceChromosome($genomeBuildAccession, $chromosomeAccession, $rangeStart, $rangeStop, $xFields)

Sequence for a region of the reference genome

Fetch a closed interval of nucleotides on a given chromosome. Includes start and stop positions

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: Bearer
$config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$apiInstance = new Lumminary\Client\Api\LumminaryAPISpecApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$genomeBuildAccession = "genomeBuildAccession_example"; // string | The accession of the reference genome
$chromosomeAccession = "chromosomeAccession_example"; // string | The accession to the chromosome
$rangeStart = 56; // int | Location on the chromosome
$rangeStop = 56; // int | Location on the chromosome
$xFields = "xFields_example"; // string | An optional fields mask

try {
    $result = $apiInstance->getReferenceChromosome($genomeBuildAccession, $chromosomeAccession, $rangeStart, $rangeStop, $xFields);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LumminaryAPISpecApi->getReferenceChromosome: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **genomeBuildAccession** | **string**| The accession of the reference genome |
 **chromosomeAccession** | **string**| The accession to the chromosome |
 **rangeStart** | **int**| Location on the chromosome |
 **rangeStop** | **int**| Location on the chromosome |
 **xFields** | **string**| An optional fields mask | [optional]

### Return type

[**\Lumminary\Client\Models\ReferenceSequence**](../Model/ReferenceSequence.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getReferenceGenome**
> \Lumminary\Client\Models\ReferenceChromosomeOverview[] getReferenceGenome($genomeBuildAccession, $xFields)

Reference genome metadata

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: Bearer
$config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$apiInstance = new Lumminary\Client\Api\LumminaryAPISpecApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$genomeBuildAccession = "genomeBuildAccession_example"; // string | 
$xFields = "xFields_example"; // string | An optional fields mask

try {
    $result = $apiInstance->getReferenceGenome($genomeBuildAccession, $xFields);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LumminaryAPISpecApi->getReferenceGenome: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **genomeBuildAccession** | **string**|  |
 **xFields** | **string**| An optional fields mask | [optional]

### Return type

[**\Lumminary\Client\Models\ReferenceChromosomeOverview[]**](../Model/ReferenceChromosomeOverview.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getReferenceGenomesGroup**
> \Lumminary\Client\Models\ReferenceGenomeOverview[] getReferenceGenomesGroup($xFields)

Reference genome builds

Lists reference genome builds that are available

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: Bearer
$config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$apiInstance = new Lumminary\Client\Api\LumminaryAPISpecApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$xFields = "xFields_example"; // string | An optional fields mask

try {
    $result = $apiInstance->getReferenceGenomesGroup($xFields);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LumminaryAPISpecApi->getReferenceGenomesGroup: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **xFields** | **string**| An optional fields mask | [optional]

### Return type

[**\Lumminary\Client\Models\ReferenceGenomeOverview[]**](../Model/ReferenceGenomeOverview.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getReferenceSnp**
> \Lumminary\Client\Models\PublicSNP getReferenceSnp($snpAccession, $dbsnpVersion, $grchVersion, $xFields)

Reference SNP data

Get reference SNP information, from dbSNP

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: Bearer
$config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$apiInstance = new Lumminary\Client\Api\LumminaryAPISpecApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$snpAccession = "snpAccession_example"; // string | The rsId of the SNP
$dbsnpVersion = 149; // int | The dbSNP build. Defaults to 149
$grchVersion = "GRCH37P13"; // string | The GRCh build on which to place snips. Defaults to GRCh37p13
$xFields = "xFields_example"; // string | An optional fields mask

try {
    $result = $apiInstance->getReferenceSnp($snpAccession, $dbsnpVersion, $grchVersion, $xFields);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LumminaryAPISpecApi->getReferenceSnp: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **snpAccession** | **string**| The rsId of the SNP |
 **dbsnpVersion** | **int**| The dbSNP build. Defaults to 149 | [optional] [default to 149]
 **grchVersion** | **string**| The GRCh build on which to place snips. Defaults to GRCh37p13 | [optional] [default to GRCH37P13]
 **xFields** | **string**| An optional fields mask | [optional]

### Return type

[**\Lumminary\Client\Models\PublicSNP**](../Model/PublicSNP.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **postAuthorizationResultCredentials**
> \Lumminary\Client\Models\ReportCredentials postAuthorizationResultCredentials($productId, $authorizationId, $credentialsUsername, $credentialsPassword, $reportUrl, $xFields)

Provide a result for the authorization

These can be log-in credentials for a website where the result is available

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: Bearer
$config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$apiInstance = new Lumminary\Client\Api\LumminaryAPISpecApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$productId = "productId_example"; // string | The UUID of the product
$authorizationId = "authorizationId_example"; // string | The UUID of the authorization
$credentialsUsername = "credentialsUsername_example"; // string | Credentials for accessing the result. Includes password, username and url
$credentialsPassword = "credentialsPassword_example"; // string | Credentials for accessing the result. Includes password, username and url
$reportUrl = "reportUrl_example"; // string | Credentials for accessing the result. Includes password, username and url
$xFields = "xFields_example"; // string | An optional fields mask

try {
    $result = $apiInstance->postAuthorizationResultCredentials($productId, $authorizationId, $credentialsUsername, $credentialsPassword, $reportUrl, $xFields);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LumminaryAPISpecApi->postAuthorizationResultCredentials: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **productId** | **string**| The UUID of the product |
 **authorizationId** | **string**| The UUID of the authorization |
 **credentialsUsername** | **string**| Credentials for accessing the result. Includes password, username and url | [optional]
 **credentialsPassword** | **string**| Credentials for accessing the result. Includes password, username and url | [optional]
 **reportUrl** | **string**| Credentials for accessing the result. Includes password, username and url | [optional]
 **xFields** | **string**| An optional fields mask | [optional]

### Return type

[**\Lumminary\Client\Models\ReportCredentials**](../Model/ReportCredentials.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

 - **Content-Type**: application/x-www-form-urlencoded, multipart/form-data
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **postAuthorizationResultFile**
> \Lumminary\Client\Models\ReportFile postAuthorizationResultFile($productId, $authorizationId, $fileReport, $originalFilename, $xFields)

Provide a file result to the authorization, e

g. a pdf report

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: Bearer
$config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$apiInstance = new Lumminary\Client\Api\LumminaryAPISpecApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$productId = "productId_example"; // string | The UUID of the product
$authorizationId = "authorizationId_example"; // string | The UUID of the authorization
$fileReport = "/path/to/file.txt"; // \SplFileObject | A binary file (e.g. pdf) that contains the result of the authorization
$originalFilename = "originalFilename_example"; // string | Optional original filename for the report. If not provided, the filename of uploaded file will be used
$xFields = "xFields_example"; // string | An optional fields mask

try {
    $result = $apiInstance->postAuthorizationResultFile($productId, $authorizationId, $fileReport, $originalFilename, $xFields);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LumminaryAPISpecApi->postAuthorizationResultFile: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **productId** | **string**| The UUID of the product |
 **authorizationId** | **string**| The UUID of the authorization |
 **fileReport** | **\SplFileObject**| A binary file (e.g. pdf) that contains the result of the authorization | [optional]
 **originalFilename** | **string**| Optional original filename for the report. If not provided, the filename of uploaded file will be used | [optional]
 **xFields** | **string**| An optional fields mask | [optional]

### Return type

[**\Lumminary\Client\Models\ReportFile**](../Model/ReportFile.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

 - **Content-Type**: multipart/form-data
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **postClientSnpGroup**
> \Lumminary\Client\Models\ClientSNP[] postClientSnpGroup($clientId, $datasetId, $snps, $xFields)

Get a large group of SNPs

SNPs that are not present in the dataset are ignored, 404 is returned only if the dataset/client does not exist

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: Bearer
$config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$apiInstance = new Lumminary\Client\Api\LumminaryAPISpecApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$clientId = "clientId_example"; // string | The UUID of the client
$datasetId = "datasetId_example"; // string | The UUID of one of the client's dataset
$snps = "snps_example"; // string | JSON-encoded list of snps to be fetched
$xFields = "xFields_example"; // string | An optional fields mask

try {
    $result = $apiInstance->postClientSnpGroup($clientId, $datasetId, $snps, $xFields);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LumminaryAPISpecApi->postClientSnpGroup: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **clientId** | **string**| The UUID of the client |
 **datasetId** | **string**| The UUID of one of the client&#39;s dataset |
 **snps** | **string**| JSON-encoded list of snps to be fetched |
 **xFields** | **string**| An optional fields mask | [optional]

### Return type

[**\Lumminary\Client\Models\ClientSNP[]**](../Model/ClientSNP.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

 - **Content-Type**: application/x-www-form-urlencoded, multipart/form-data
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **postJwtAuth**
> \Lumminary\Client\Models\JavascriptWebToken postJwtAuth($username, $password, $role, $xFields)

General-purpose authentication

## Note: * The JWT tokens returned should be passed to any resource that requires authentication, in the Authentication header, in the format `Bearer: your-token-here` * Only JWT authentication tokens are provided (no refresh tokens). These tokens are valid for 30 seconds from the moment they were issued

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$apiInstance = new Lumminary\Client\Api\LumminaryAPISpecApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$username = "username_example"; // string | The email for a Client, or the API for a partner product
$password = "password_example"; // string | The passowrd for a Client, or the API key for a service
$role = "role_example"; // string | The role for which authentication will be made. Value : role_product
$xFields = "xFields_example"; // string | An optional fields mask

try {
    $result = $apiInstance->postJwtAuth($username, $password, $role, $xFields);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LumminaryAPISpecApi->postJwtAuth: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **username** | **string**| The email for a Client, or the API for a partner product |
 **password** | **string**| The passowrd for a Client, or the API key for a service |
 **role** | **string**| The role for which authentication will be made. Value : role_product |
 **xFields** | **string**| An optional fields mask | [optional]

### Return type

[**\Lumminary\Client\Models\JavascriptWebToken**](../Model/JavascriptWebToken.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/x-www-form-urlencoded, multipart/form-data
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **postProductAuthorization**
> postProductAuthorization($productId, $authorizationId)

Signal that processing is complete, without uploading any result

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: Bearer
$config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$apiInstance = new Lumminary\Client\Api\LumminaryAPISpecApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$productId = "productId_example"; // string | The UUID of the product
$authorizationId = "authorizationId_example"; // string | The UUID of the authorization

try {
    $apiInstance->postProductAuthorization($productId, $authorizationId);
} catch (Exception $e) {
    echo 'Exception when calling LumminaryAPISpecApi->postProductAuthorization: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **productId** | **string**| The UUID of the product |
 **authorizationId** | **string**| The UUID of the authorization |

### Return type

void (empty response body)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **postProductAuthorizationUnfulfillable**
> \Lumminary\Client\Models\Authorization postProductAuthorizationUnfulfillable($productId, $authorizationId, $xFields)

Catch-all Authorization state, for authorizations that passed all verifications and should reach the partner Product, but cannot be fulfilled for various reasons

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: Bearer
$config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKey('Authorization', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Lumminary\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Authorization', 'Bearer');

$apiInstance = new Lumminary\Client\Api\LumminaryAPISpecApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$productId = "productId_example"; // string | The UUID of the product
$authorizationId = "authorizationId_example"; // string | The UUID of the authorization
$xFields = "xFields_example"; // string | An optional fields mask

try {
    $result = $apiInstance->postProductAuthorizationUnfulfillable($productId, $authorizationId, $xFields);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LumminaryAPISpecApi->postProductAuthorizationUnfulfillable: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **productId** | **string**| The UUID of the product |
 **authorizationId** | **string**| The UUID of the authorization |
 **xFields** | **string**| An optional fields mask | [optional]

### Return type

[**\Lumminary\Client\Models\Authorization**](../Model/Authorization.md)

### Authorization

[Bearer](../../README.md#Bearer)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

