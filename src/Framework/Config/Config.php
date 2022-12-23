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
    // END PAGINATION

    // START WEBAPP
    'webapp.rest_endpoint' => 'api',
    'webapp.jwt_secret' => 'test_123',
    'webapp.jwt_encoding' => 'HS256',
    // END WEBAPP

    // MIDDLEWARE
    'middleware.authentication.sec_regenerate_session' => '300',
    'middleware.authentication.sec_expire_session' => '360',
    // END MIDDLEWARE
];
