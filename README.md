#Audit for Laravel 5

This package will help you to keep revision of your object. For instance, one need to keep track of updates or text changes for any blog post or maintain history who changed it. Also this package is flexible enough to mould according to one's requirement.

To register this package with Laravel you need to add this line to your provider's array:

    'Focalworks\Audig\AuditServiceProvider'

This package has configuration files and migration files, so once the service provider is registered with your application, you need to run the following console command to publish the vendor files and run migrations:

    php artisan vendor:publish
    
    php artisan migrate

It will publish one config file "audit.php" inside config folder, migration file inside database/migrations folder and "assets" folder inside public folder.

##Usage

To create or save revisions of any object follow the steps as below :

 1. Add "use Focalworks\Audit\Audit;" in your controller
 2. Implements interface "content" in your class which will return type of your content
 3. To create copy of your content use "Audit::makeVersion($yourObject)"

    For example:

                 $blogPost = new blog(); //your object;
                 $blogPost->title = 'My first post';
                 $blogPost->description = 'My first post description';

                 Audit::makeVersion($blogPost); //usage

 4. To view revisions go to "http://yourdomain.com/audit/content_type/content_id"

    For example,your url will looks like http://localhost/audit-mgmt/public/audit/blog/1

Also there is an interface from where you can see the list of all revisions using URL "http://yourdomain.com/audit-history".
