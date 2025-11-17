# MessageClient (PHP)

A lightweight PHP client for interacting with the **MessengerService**, providing authenticated access to send messages and query message-history state.  
This client uses OAuth2 bearer tokens (no more username/password auth inside the client) and exposes a small interface for sending and checking messages.

----------

## Features

-   Uses **OAuth2 access tokens** for authentication

-   Simple instance-based client (`new MessageClient($url, $token)`)

-   JSON-encoded message sending

-   Helper for checking if a message with a given `msg_name` and `flag` has already been sent

-   Minimal dependencies – pure cURL


----------

## Requirements

Before using this client:

1.  Your application must be registered in the **AccountService**.

2.  You must obtain an **OAuth2 access token** for the Messenger audience.


### Example OAuth2 Token Request

```bash
curl --location --request POST 'https://auth.outlawdesigns.io/oauth2/token' \
  --form 'grant_type="client_credentials"' \
  --form 'client_id="$CLIENT_ID"' \
  --form 'client_secret="$CLIENT_SECRET"' \
  --form 'audience="https://messenger.outlawdesigns.io"' \
  --form 'scope="openid profile email roles"'

```

Then pass the resulting `access_token` into the MessageClient constructor.

----------

## Installation

Simply include the class file in your project:

```php
require_once 'MessageClient.php';

```

(If you'd like a composer-ready structure, I can generate one.)

----------

## Usage

### Initializing the Client

```php
$client = new MessageClient(
    'https://messenger.outlawdesigns.io',
    $accessToken
);

```

Ensure the base URL does **not** include `/send` or `/sent/...`; the client appends those automatically.

----------

## Methods

### `send(array $message): object`

Sends a message through MessengerService.  
Returns the decoded JSON response (typically a `SentMessage` object).

Throws an exception if the API returns an error.

#### Example

```php
$message = [
    "to"       => [$recipient],
    "subject"  => "Hello World!",
    "msg_name" => "hello_world_test",
    "body"     => "Hello world!",
    "flag"     => date('Y-m-d')
];

$response = $client->send($message);

print_r($response);

```

----------

### `isSent(string $msg_name, string $flag): bool`

Checks whether a message with the given `msg_name` and `flag` has already been delivered.  
Returns:

-   `true` → message already sent

-   `false` → message not sent

-   **throws Exception** → API error


#### Example

```php
if (!$client->isSent('hello_world_test', date('Y-m-d'))) {
    echo "Message has not been sent today.\n";
}

```

----------

## Error Handling

API errors are returned in JSON with an `error` property.  
The client automatically throws an exception:

```php
try {
    $client->send($message);
} catch (Exception $e) {
    echo "Messenger error: " . $e->getMessage();
}

```

----------

## Related Services

-   **MessengerService:**  
    [https://github.com/outlawdesigns-io/MessengerService](https://github.com/outlawdesigns-io/MessengerService)
