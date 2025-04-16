
# Authentication

## Introduction
All API calls on the Toornament APIs require your application to be authenticated, whether you use the simple access or the authorized access. This authentication is performed using an API key.

## What is an API key?
When your application must be authenticated on the Toornament API, it will use an API key. It represents some kind of login/password but designed for computer software. As for humans, an application only has a single API key, so keep it safe.

To obtain a valid key, you must simply create an application. After registering your application, you will find the API key on the profile of your application.

> **Note:** This key should normally never change unless there is an abusive use or a security issue. In both cases, if an API key is revoked, you will be able to find a new one on the profile of your application.

## Authenticate using an API key
Since the API key functions like a login/password for your application, it will be used to authenticate your application on the Toornament API. However, since a REST API is stateless, it will not preserve any state between calls. Therefore, you need to authenticate your application on each call. This can be performed by using one of the two methods:

- Adding the `X-Api-Key` HTTP header
- Adding the `api_key` URL query parameter (**dev only**)

> ⚠️ **Warning:** The HTTP header is strongly suggested for the production environment for security reasons. It avoids leaking the key when a URL is copy-pasted or leaving the key visible in server logs. However, we also provide the query parameter method to facilitate your application's development.

## HTTP header
```http
GET /endpoint HTTP/1.1
Host: api.toornament.com
...
X-Api-Key: {api-key}
```

## URL query parameter (dev only)
```
https://api.toornament.com/endpoint?api_key={api-key}
```
