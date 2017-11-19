<?php


namespace Fredtro\MailerBundle\Exception;

use Prophecy\Exception\Exception;


/**
 *
 * @author Frederik Trostorf <fredtrostorf@gmail.com>
 *
 * Class BlockNotDefinedException
 */
class BlockNotDefinedException extends \RuntimeException
{
    public function __construct($block, $code = 0, Exception $previous = null)
    {
        parent::__construct(
            sprintf('Block "%s" not defined. At least one of the blocks "text" or "html" needs to be defined.', $block),
            $code,
            $previous
        );
    }
}