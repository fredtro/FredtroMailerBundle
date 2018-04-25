<?php


namespace Fredtro\MailerBundle\Event;

/**
 *
 * @author Frederik Trostorf <frederik.trostorf@ongoing.ch>
 *
 * Class MailerEvents
 */
class MailerEvents
{

    /**
     * fired before email is sent
     */
    const BEFORE_EMAIL_SENT = 'fredtro.before.email.sent';

    /**
     * fired after sending email
     */
    const EMAIL_SENT = 'fredtro.email.sent';
}
