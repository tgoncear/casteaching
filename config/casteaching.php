<?php
return [
    'default_user'=>[
        'passwordSergi' => env('SERGI_USER_PASSWORD','12345678'),
        'nameSergi' => env('SERGI_USER_NAME','Sergi Tur'),
        'emailSergi' => env('SERGI_USER_EMAIL','sergiturbadenas@gmail.com'),
        'passwordTudor' => env('TUDOR_USER_PASSWORD','12345678'),
        'nameTudor' => env('TUDOR_USER_NAME','Tudor Goncear'),
        'emailTudor' => env('TUDOR_USER_EMAIL','tgoncear@iesebre.com'),
        'passwordUser' => env('TUDOR_USER_PASSWORD','12345678'),
        'nameUser' => env('TUDOR_USER_NAME','Tudor Goncear'),
        'emailUser' => env('TUDOR_USER_EMAIL','tudorg2015@gmail.com')
    ],
    'admins' => [
        'tgoncear@iesebre.com',
        'sergiturbadenas@gmail.com'
    ]

];

