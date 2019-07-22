# Product

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**snpsAuthorizedAny** | **bool** | A boolean value specifying if SNP set is not strict | 
**productPartners** | **string[]** | A list of Partner UUIDs that manage the product | 
**snpsAuthorized** | **string[]** | A superset of snps_min_required, containing all SNPs to which an Product has access (includes optional SNPs) | 
**authorizedScopes** | **string[]** | A list of scopes that the product can require from clients | 
**email** | **string** | The contact email for the product | [optional] 
**redirectUri** | **string** | A redirect url registered as a callback for the Connect with Lumminary authorization flow | [optional] 
**snpsMinRequiredAny** | **bool** | A boolean value specifying if SNP set is not strict | 
**snpsMinRequired** | [**\Lumminary\Client\Models\SnpsMinRequired**](SnpsMinRequired.md) | Minimum required snps for Dataset-Product compatibility | 
**productUuid** | **string** | The product identifier | 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)


