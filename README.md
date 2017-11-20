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

Define a twig template:

```twig

{% block subject %}subject{% endblock %}
{% block text %}Hello {{username}}!{% endblock %}
{% block html %}<h1>Hello {{username}}!</h1>{% endblock %}

```

Send mail:


```php

public function someAction(){

    $mailer = $this->get('fredtro.mailer');
    $mailer->send('template.twig', 'bar@example.com', ['username' => 'fred']);
}

```

Additional features:
----------------------
###Callback

For access the \Swift_Message created before sending, you can pass a callback (Instance of Closure). You can use this for e.g. adding attachments, set reply or anything else related to the message object.

```php

public function someAction(){

    $mailer = $this->get('fredtro.mailer');
    $mailer->send('template.twig', 'bar@example.com', ['username' => 'fred'], function(\Swift_Message $message){
        //do your modifications here
        $message->setFrom(['somebodyelse@example.com']);
    });
}

```

###Events
```php

Before sending email: Fredtro\MailerBundle\Event\MailerEvents::BEFORE_EMAIL_SENT

After sending email: Fredtro\MailerBundle\Event\MailerEvents::EMAIL_SENT

```

Both use the Generic Event class from Symfony. The EMAIL_SENT event additionally provides the attribute 'sent', containing the swift result ([Mailer](https://github.com/fredtro/FredtroMailerBundle/blob/master/Mailer/Mailer.php)).


