<?php


namespace Fredtro\MailerBundle\Mailer;

use Fredtro\MailerBundle\Model\Mailer\Config;


/**
 *
 * @author Frederik Trostorf <frederik.trostorf@ongoing.ch>
 *
 * Interface MailerInterface
 */
interface MailerInterface
{
    /**
     * @param $template
     * @param $to
     * @param array $context
     * @param array $from
     * @param \Closure $callback
     * @return int
     */
    public function sendMessage($template, $to, $context = array(), $from = array(), \Closure $callback = null);
}