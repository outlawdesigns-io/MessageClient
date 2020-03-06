# MessageClient

MessageClient is an abstract class that provides access to <a href="https://github.com/outlawdesigns-io/MessengerService">MessengerService</a>

## Requirements

Clients who wish to access <a href="https://github.com/outlawdesigns-io/MessengerService">MessengerService</a> be registered with <a href="https://github.com/outlawdesigns-io/AccountService">AccountService</a> and authenticated before they can request data.

## Methods

### authenticate($username:string,$password:string)

Authenticate against <a href="https://github.com/outlawdesigns-io/AccountService">AccountService</a>. Returns a credential object containing your authorization token and secret.

Throws an exception on error. (Bad credentials, account locked etc.)

### verifyToken($token:string)

Verify the validity of an authorization token. Throws an exception when verifying a bad token.

### send($message,$token:string)

Send a message.

### isSent($msg_name:string,$flag:string,$token:string)

Determine if a specific message has already been sent based on its 'MessageName' and 'Flag', parameters that are provided when POSTing a new message to the service. Returns a boolean.
