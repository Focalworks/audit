#Audit for Laravel 5

This module will help you to keep revision of your object. For instance, one need to keep track of updates or text changes for any blog post or maintain history who changed it.

To register this package with Laravel you need to add this line your provider's array:

    'Focalworks\Audig\AuditServiceProvider'

This package has configuration files and migration files, so once the service provider is registered with your application, you need to run the following console command to publish the vendor files:

    php artisan vendor:publish

It will publish one config file "audit.php" inside config folder, migration file inside database/migrations folder and "assets" folder inside public folder.
