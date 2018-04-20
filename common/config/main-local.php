<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;port=3307;dbname=yii2advanced',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8'
        ],
        'mailer' => [
            // 'class' => 'yii\swiftmailer\Mailer',
            // 'viewPath' => '@common/mail',
            // // send all mails to a file by default. You have to set
            // // 'useFileTransport' to false and configure a transport
            // // for the mailer to send real emails.
            // 'useFileTransport' => true,
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'zmailus.bankaigroup.com',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'b2calert@panamaxil.com',
                'password' => 'P@n.12345',
                'port' => '25', // Port 25 is a very common port too
                'encryption' => 'tls', // It is often used, check your provider or mail server specs
            ],
        ],        
    ],
    'bootstrap' => 'gii',
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'generators' => [
                'doubleModel' => [
                    'class' => 'claudejanz\mygii\generators\model\Generator',
                ],
            ],
        ],
    ],
];
