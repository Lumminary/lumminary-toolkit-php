# Lumminary\Client\AuthApi

All URIs are relative to *https://api.lumminary.com/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**postJwtAuth**](AuthApi.md#postJwtAuth) | **POST** /auth/jwt | General-purpose authentication


# **postJwtAuth**
> \Lumminary\Client\Models\JavascriptWebToken postJwtAuth($username, $password, $role, $_2FAToken, $xFields)

General-purpose authentication

If 2FA is enabled, the 2FA token is validated along with the username/password pair. Otherwise, the 2FA token, even if provided, is ignored.  ## Note: * A fresh and not previously used 2FA token should be passed, otherwise authentication will fail. * The JWT tokens returned should be passed to any resource that requires authentication, in the Authentication header, in the format `Bearer: your-token-here` * Only JWT authentication tokens are provided (no refresh tokens). These tokens are valid for 30 seconds from the moment they were issued

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$apiInstance = new Lumminary\Client\Api\AuthApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$username = "username_example"; // string | The email for a Client, or the API for a partner product
$password = "password_example"; // string | The passowrd for a Client, or the API key for a service
$role = "role_example"; // string | The role for which authentication will be made. Value : role_product
$_2FAToken = "_2FAToken_example"; // string | The One-time password provided by a 2FA product, if enabled
$xFields = "xFields_example"; // string | An optional fields mask

try {
    $result = $apiInstance->postJwtAuth($username, $password, $role, $_2FAToken, $xFields);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthApi->postJwtAuth: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **username** | **string**| The email for a Client, or the API for a partner product |
 **password** | **string**| The passowrd for a Client, or the API key for a service |
 **role** | **string**| The role for which authentication will be made. Value : role_product |
 **_2FAToken** | **string**| The One-time password provided by a 2FA product, if enabled | [optional]
 **xFields** | **string**| An optional fields mask | [optional]

### Return type

[**\Lumminary\Client\Models\JavascriptWebToken**](../Model/JavascriptWebToken.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/x-www-form-urlencoded, multipart/form-data
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

