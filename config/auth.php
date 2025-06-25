<?php

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'superadmin' => [
            'driver' => 'session',
            'provider' => 'superadmins',
        ],

        'branchadmin' => [ // ✅ Use this consistently everywhere
            'driver' => 'session',
            'provider' => 'branch_admins',
        ],
        'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'branchadmin' => [
        'driver' => 'session',
        'provider' => 'branch_admins', // or maybe 'users' if you're reusing the user table
    ],
    'web' => [
        'driver' => 'session',
        'provider' => 'patients', // <-- important
    ]
],


        'patient' => [
            'driver' => 'session',
            'provider' => 'patients',
        ],
        'rider' => [
            'driver' => 'session',
            'provider' => 'riders',
        ],
        'manager' => [
            'driver' => 'session',
            'provider' => 'managers',
        ],
        
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'patients' => [
            'driver' => 'eloquent',
            'model' => App\Models\Patient::class, // <-- your model
        ],
        'superadmins' => [
            'driver' => 'eloquent',
            'model' => App\Models\SuperAdmin::class,
        ],

        'branch_admins' => [ // ✅ Matches "branchadmin" guard
            'driver' => 'eloquent',
            'model' => App\Models\BranchAdmin::class,
        ],

        'patients' => [
            'driver' => 'eloquent',
            'model' => App\Models\Patient::class,
        ],
        'riders' => [
            'driver' => 'eloquent',
            'model' => App\Models\Rider::class,
        ],
        'rider' => [
            'driver' => 'session',
            'provider' => 'riders',
        ],
        'managers' => [ // ✅ provider for manager
        'driver' => 'eloquent',
        'model' => App\Models\Manager::class,
    ],

     
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'superadmins' => [
            'provider' => 'superadmins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'patients' => [
            'provider' => 'patients',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'managers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Manager::class,
        ],
    ],

    'password_timeout' => 10800,

];
