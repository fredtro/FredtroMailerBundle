<?php


namespace Fredtro\MailerBundle\Exception;

use Prophecy\Exception\Exception;


/**
 *
 * @author Frederik Trostorf <frederik.trostorf@ongoing.ch>
 *
 * Class BlockNotFoundException
 */
class InvalidBlocksException extends \RuntimeException
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct('At least one of the blocks "text" or "html" needs to be defined.', $code, $previous);
    }
}