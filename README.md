# MessageClient

MessageClient is an abstract class that provides access to <a href="https://github.com/outlawdesigns-io/MessengerService">MessengerService</a>.

MessageClient can be extended into concrete implementations, but its basic methods are static and can be called without a concrete implementation or an initialization.

## Requirements

Clients who wish to access <a href="https://github.com/outlawdesigns-io/MessengerService">MessengerService</a> be registered with <a href="https://github.com/outlawdesigns-io/AccountService">AccountService</a> and authenticated before they can request data.

## Methods

### authenticate($username:string,$password:string)

Static. Authenticate against <a href="https://github.com/outlawdesigns-io/AccountService">AccountService</a>. Returns a credential object containing your authorization token and secret.

Throws an exception on error. (Bad credentials, account locked etc.)

```
print_r(MessageClient::authenticate('MyUsername','MyPassword'));
```

### verifyToken($token:string)

Static. Verify the validity of an authorization token. Returns the verified token. Throws an exception when verifying a bad token.

```
try{
  echo MessageClient::verifyToken('12345') . "\n";
}catch(\Exception $e){
  echo $e->getMessage() . "\n";
}
```

### send($message:AssociativeArray,$token:string)

Static. Send a message. Returns a SentMessage Object on success.

```
$msg = array(
  "to"=>array($msgTo),
  "subject"=>'Hello World!',
  "msg_name"=>'hello_world_test',
  "body"=>'Hello world!',
  "flag"=>date('Y-m-d')
);

$response = json_decode(MessageClient::send($msg,$authToken));
```

### isSent($msg_name:string,$flag:string,$token:string)

Determine if a specific message has already been sent based on its 'MessageName' and 'Flag' (properties of <a href="https://github.com/outlawdesigns-io/MessengerService">MessengerService's</a>) SentMessage model. Returns a boolean.

```
if(!MessageClient::isSent('hello_world_test',date('Y-m-d'),$authToken)){
  echo "Message has not been sent today. Sending now...\n";
}
```
