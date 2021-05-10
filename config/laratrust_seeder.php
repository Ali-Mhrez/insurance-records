<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [

        'administrator' => [
            'users' => 'c,r,u,d',
            'initial_records' => 'r,d,i,s,e,gr',
            'final_records' => 'r,d,i,s,e,gr'


        ],

        'user' => [],

    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'i' => 'input',
        's' => 'search',
        'e' => 'edit',
        'gr'=> 'generate_reports'
    ]
];
