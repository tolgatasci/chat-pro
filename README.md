
## Features

- **Real-Time Messaging:** Integrated real-time communication with WebSockets and Laravel Echo.
- **Multi-Participant Support:** Create one-on-one and group chats.
- **Flexible Structure:** Easily extendable and customizable, adhering to SOLID principles.
- **Security:** Secure messaging with authorization and validation checks.
- **Customizable:** Full control with publishable configuration and view files.

## Requirements

- PHP >= 7.4
- Laravel 8.x, 9.x, or 10.x
- Composer

## Installation

To add the package to your project, follow the steps below.

### 1. Install the Package with Composer

```bash
composer require tolgatasci/chat 
```

### 2. Register the Service Provider and Facade (For Laravel 5.4 and Older Versions)
You can skip this step in Laravel 5.5 and above due to automatic package discovery.
```php
// config/app.php

'providers' => [
    // ...
    TolgaTasci\Chat\Providers\ChatServiceProvider::class,
],

'aliases' => [
    // ...
    'Chat' => TolgaTasci\Chat\Facades\Chat::class,
],
```

### 3. Publish the Configuration File

```bash
php artisan vendor:publish --provider="TolgaTasci\Chat\Providers\ChatServiceProvider" --tag="config"
```

### 4. Publish and Run Migrations

```bash
php artisan vendor:publish --provider="TolgaTasci\Chat\Providers\ChatServiceProvider" --tag="migrations"

php artisan migrate
```

### 5. Add the Messageable Trait to Your Model
Use the Messageable trait in models that you want to participate in messaging.
```php
use Illuminate\Foundation\Auth\User as Authenticatable;
use TolgaTasci\Chat\Traits\Messageable;

class User extends Authenticatable
{
    use Messageable;

    // ...
}
```

## Usage
### Creating a Conversation
You can create a new conversation with two or more participants.
```php
use TolgaTasci\Chat\Facades\Chat;

$participants = [$user1, $user2];

$conversation = Chat::createConversation($participants);
```
### Sending a Message
To send a message to a conversation:
```php
$message = Chat::sendMessage($conversation, $sender, 'Hello!', 'text', ['foo' => 'bar']);
```
- $conversation: The conversation where the message will be sent.
- $sender: The user sending the message.
- 'Hello!': The content of the message.
- 'text': Message type (optional).
- ['foo' => 'bar']: Additional data (optional).

### Retrieving Messages
To retrieve messages in a specific conversation:
```php
$messages = Chat::getMessages($conversation, $perPage = 25);
```
### Listing Conversations
To list the conversations a user is involved in:
```php
$conversations = $user->conversations;
```
### Authorization and Validation
Authorization checks are made during conversation and message operations using policies. For example, to check if a user has access to a conversation:
```php
$this->authorize('view', $conversation);
```
### Real-Time Communication
For real-time communication, you can use Laravel Echo and Pusher (or your WebSocket provider of choice).

### Laravel Echo Setup
Configure Laravel Echo in your `resources/js/bootstrap.js` file:

```js
import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true,
});
```

### Listening to Events
For example, in a Vue.js component:

```js
mounted() {
    Echo.join(`conversation.${this.conversationId}`)
        .here((users) => {
            this.participants = users;
        })
        .joining((user) => {
            this.participants.push(user);
        })
        .leaving((user) => {
            this.participants = this.participants.filter(u => u.id !== user.id);
        })
        .listen('MessageSent', (e) => {
            this.messages.push(e.message);
        });
},
```

### Testing
Tests have been written to ensure the reliability of your package. To run the tests:

```bash
vendor/bin/phpunit
```

## Customization
### Configuration

You can customize the package settings in the `config/chat.php` file.

- user_model: The user model to be used in the messaging system.
- broadcast_driver: The broadcast driver to be used (e.g., pusher, ably).

### Views
To publish and customize the view files:

```bash
php artisan vendor:publish --provider="TolgaTasci\Chat\Providers\ChatServiceProvider" --tag="views"
```

### Security
- Authorization: Ensures users can only access the conversations and messages they are authorized for through policies.
- Input Validation: User inputs are validated using Form Request classes.
- XSS and CSRF Protection: Laravel's default protections are used.

## Contributing
We welcome contributions. To contribute, please follow these steps:

* Fork this project.
* Create a new branch: git checkout -b my-new-feature.
* Make your changes and commit them: git commit -am 'Add some feature'.
* Push to your branch: git push origin my-new-feature.
* Open a Pull Request.

## License
This project is licensed under the MIT License. For more information, see the [LICENSE](LICENSE) file.
