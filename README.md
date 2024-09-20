## Özellikler

- **Gerçek Zamanlı Mesajlaşma:** WebSockets ve Laravel Echo ile entegre gerçek zamanlı iletişim.
- **Çoklu Katılımcı Desteği:** Bire bir sohbetler ve grup sohbetleri oluşturma.
- **Esnek Yapı:** SOLID prensiplerine uygun, kolay genişletilebilir ve özelleştirilebilir.
- **Güvenlik:** Yetkilendirme ve doğrulama kontrolleri ile güvenli mesajlaşma.
- **Özelleştirilebilir:** Yayınlanabilir konfigürasyon ve görünüm dosyaları ile tam kontrol.

## Gereksinimler

- PHP >= 7.4
- Laravel 8.x, 9.x veya 10.x
- Composer

## Kurulum

Paketinizi projenize eklemek için aşağıdaki adımları izleyin.

### 1. Composer ile Paketi Yükleyin

```bash
composer require tolgatasci/chat
```

### 2. Servis Sağlayıcısını ve Facade'i Kaydedin (Laravel 5.4 ve Öncesi için)
Laravel 5.5 ve üzeri sürümlerde otomatik paket keşfi sayesinde bu adımı atlayabilirsiniz.
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
### 3. Konfigürasyon Dosyasını Yayınlayın

```bash
php artisan vendor:publish --provider="TolgaTasci\Chat\Providers\ChatServiceProvider" --tag="config"
```

### 4. Migration'ları Yayınlayın ve Çalıştırın

```bash
php artisan vendor:publish --provider="TolgaTasci\Chat\Providers\ChatServiceProvider" --tag="migrations"

php artisan migrate
```

### 5. Modelinize Messageable Özelliğini Ekleyin
Mesajlaşmaya katılmasını istediğiniz modellerde Messageable trait'ini kullanın.
```php
use Illuminate\Foundation\Auth\User as Authenticatable;
use TolgaTasci\Chat\Traits\Messageable;

class User extends Authenticatable
{
    use Messageable;

    // ...
}
```



## Kullanım
### Sohbet Oluşturma
İki veya daha fazla katılımcı ile yeni bir sohbet oluşturabilirsiniz.
```php
use TolgaTasci\Chat\Facades\Chat;

$participants = [$user1, $user2];

$conversation = Chat::createConversation($participants);
```
### Mesaj Gönderme
Bir sohbete mesaj göndermek için:
```php
$message = Chat::sendMessage($conversation, $sender, 'Merhaba!', 'text', ['foo' => 'bar']);
```
- $conversation: Mesajın gönderileceği sohbet.
- $sender: Mesajı gönderen kullanıcı.
- 'Merhaba!': Mesaj içeriği.
- 'text': Mesaj tipi (isteğe bağlı).
- ['foo' => 'bar']: Ek veri (isteğe bağlı).

### Mesajları Getirme
Belirli bir sohbetteki mesajları almak için:
```php
$messages = Chat::getMessages($conversation, $perPage = 25);
```
### Sohbetleri Listeleme
Bir kullanıcının dahil olduğu sohbetleri listelemek için:
```php
$conversations = $user->conversations;
```
### Yetkilendirme ve Doğrulama
Sohbet ve mesaj işlemleri sırasında policy'leri kullanarak yetkilendirme kontrolleri yapılır. Örneğin, bir kullanıcının bir sohbete erişimi olup olmadığını kontrol etmek için:
```php
$this->authorize('view', $conversation);
```
### Gerçek Zamanlı İletişim
Gerçek zamanlı iletişim için Laravel Echo ve Pusher (veya tercih ettiğiniz bir WebSocket sağlayıcısı) kullanabilirsiniz.
### Laravel Echo Ayarları
resources/js/bootstrap.js dosyanızda Laravel Echo'yu yapılandırın:

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

### Olayları Dinleme
Örneğin, bir Vue.js bileşeninde:

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

### Testler
Paketinizin güvenilirliğini sağlamak için testler yazılmıştır. Testleri çalıştırmak için:

```bash
vendor/bin/phpunit
```
## Özelleştirme
### Konfigürasyon

config/chat.php dosyasında paket ayarlarını özelleştirebilirsiniz.

- user_model: Mesajlaşma sisteminde kullanılacak kullanıcı modeli.
- broadcast_driver: Kullanılacak yayın sürücüsü (örneğin, pusher, ably).

### Görünümler
Görünüm dosyalarını yayınlamak ve özelleştirmek için:

```bash
php artisan vendor:publish --provider="TolgaTasci\Chat\Providers\ChatServiceProvider" --tag="views"
```
### Güvenlik
- Yetkilendirme: Policy'ler aracılığıyla kullanıcıların sadece yetkili oldukları sohbetlere ve mesajlara erişmesi sağlanır.
- Girdi Doğrulama: Form Request sınıfları kullanılarak kullanıcı girdileri doğrulanır.
- XSS ve CSRF Koruması: Laravel'in varsayılan korumaları kullanılır.
## Katkıda Bulunma
Katkılarınızı memnuniyetle kabul ediyoruz. Lütfen katkıda bulunmak için aşağıdaki adımları izleyin:

* Bu projeyi forklayın.
* Yeni bir dal oluşturun: git checkout -b my-new-feature.
* Değişikliklerinizi yapın ve commit edin: git commit -am 'Add some feature'.
* Dalınıza push edin: git push origin my-new-feature.
* Bir Pull Request açın.
## Lisans
Bu proje MIT lisansı altında lisanslanmıştır. Daha fazla bilgi için [LICENSE](LICENSE) dosyasına bakın.