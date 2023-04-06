<?php

return [
    'models' => [
        'permission' => \Modules\Core\Models\Permission::class,
        'locale' => \Modules\Core\Models\Locale::class,
        'localekey' => \Modules\Core\Models\Localekey::class,
    ],
    'repository_url' => 'http://localhost:8088/storage',
//    'repository_url'=>'nginx/storage',
    'module' => [
        'installation_yaml' => 'installation.yml',
        'server_folder' => 'Modules',
        'client_folder' => 'js/modules',
    ],
];
