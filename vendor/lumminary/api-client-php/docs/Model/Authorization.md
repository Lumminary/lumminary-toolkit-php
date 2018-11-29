# Authorization

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**scopes** | [**\Lumminary\Client\Models\AccessScope**](AccessScope.md) |  | 
**clientUuid** | **string** | The UUID of the client owning the Dataset to which the product is authorized | 
**isActive** | **bool** | If false, the the authorization is revoked and data access authorizations fail | 
**authorizationUuid** | **string** | Identifier of the Authorization | 
**productUuid** | **string** | Identifier of the Product to be authorized | 
**state** | **string** | The authorization state. One of : [&#39;authorization_state_pending_dataset&#39;, &#39;authorization_state_fulfillable&#39;, &#39;authorization_state_result_available&#39;] | 
**createTimestamp** | **int** | Creation timestamp for the Authorization | 
**reportCredentials** | [**\Lumminary\Client\Models\ReportCredentials[]**](ReportCredentials.md) |  | [optional] 
**reportFiles** | [**\Lumminary\Client\Models\ReportFile[]**](ReportFile.md) |  | [optional] 
**order** | **string** | Optional UUID of the Order that created the Authorization | [optional] 
**sequenceNumber** | **int** | The sequence number of the Authorization. Used as a filter when fetching new Authorizations | [optional] 

[[Back to Model list]](../README.md#documentation-for-models) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to README]](../README.md)


