<?php


namespace Fredtro\MailerBundle\Exception;

use Exception;


/**
 *
 * @author Frederik Trostorf <frederik.trostorf@ongoing.ch>
 *
 * Class NoRecipientException
 */
class NoRecipientException extends \InvalidArgumentException
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct('Cannot send email without a recipient.', $code, $previous);
    }

}