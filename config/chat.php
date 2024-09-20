<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Kullanıcı Modeli
    |--------------------------------------------------------------------------
    |
    | Sohbet sistemi tarafından kullanılan kullanıcı modelini tanımlayın.
    |
    */

   // 'user_model' => App\Models\User::class,
    'user_model' => TolgaTasci\Chat\Tests\Stubs\Models\User::class,

    /*
    |--------------------------------------------------------------------------
    | Gerçek Zamanlı İletişim Sürücüsü
    |--------------------------------------------------------------------------
    |
    | Pusher, Ably veya Soket.IO gibi sürücülerden birini kullanabilirsiniz.
    |
    */

    'broadcast_driver' => env('BROADCAST_DRIVER', 'pusher'),

];
