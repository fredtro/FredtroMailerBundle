#FredtroMailerBundle

Provides mailer for sending emails using twig templates. Initially inspired by [FOSUserBundle TwigSwiftMailer](https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Mailer/TwigSwiftMailer.php).

Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require fredtro/mailer-bundle "^1.0"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Fredtro\MailerBundle\FredtroMailerBundle(),
        );

        // ...
    }

    // ...
}
```
Step 3: Configuration
-------------------------

At least the from address needs to be configured. Name is optionally. 

```yaml
fredtro_mailer:
    from:
        address: foo@example.com
        name: Example Customer Service
```

Step 4: Sending Emails
--------------------------

```php

public function someAction(){

    $mailer = $this->get('fredtro.mailer');
    $mailer->send('template.twig', 'bar@example.com');
}

```
