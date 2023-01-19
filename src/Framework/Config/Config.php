<?php

return [ // TODO: change to env variables or properties
    // START DATABASE
    'database.host' => 'ddev-be-uebung-db',
    'database.port' => '3306',
    'database.dbname' => 'desksharing_dev',
    'database.user' => 'root',
    'database.password' => 'root',
    // END DATABASE

    // START STATIC FILES
    'static_files.supported_extensions' => ['js', 'css', 'png', 'jpg'],
    // END STATIC FILES

    // PAGINATION
    'pagination.bookings_per_page' => 5,
    'pagination.users_per_page' => 10, // Admin Panel
    // END PAGINATION

    // START REST api
    'restapi.payload.iss' => 'http://localhost:8080',
    'restapi.payload.aud' => 'http://localhost:8080',
    'restapi.payload.iat' => time(),
    'restapi.payload.exp' => time() + 60 * 60,
    'restapi.secret.key' => 'testsecretkey',
    'restapi.cypher.algorithm' => 'HS256',
    // END REST api

    // MIDDLEWARE
    'middleware.authentication.sec_regenerate_session' => '300',
    'middleware.authentication.sec_expire_session' => '360',
    // END MIDDLEWARE
];
