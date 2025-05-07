# OpenAPI\Client\AuthenticationApi

All URIs are relative to http://localhost, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**register()**](AuthenticationApi.md#register) | **POST** /api/v1/register | User Registration |


## `register()`

```php
register($register_request): \OpenAPI\Client\Model\Register200Response
```

User Registration

Registers a new user and sends a verification email.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new OpenAPI\Client\Api\AuthenticationApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$register_request = new \OpenAPI\Client\Model\RegisterRequest(); // \OpenAPI\Client\Model\RegisterRequest

try {
    $result = $apiInstance->register($register_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthenticationApi->register: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **register_request** | [**\OpenAPI\Client\Model\RegisterRequest**](../Model/RegisterRequest.md)|  | |

### Return type

[**\OpenAPI\Client\Model\Register200Response**](../Model/Register200Response.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
