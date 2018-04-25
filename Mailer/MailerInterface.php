<?php


namespace Fredtro\MailerBundle\Mailer;

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
     * @param \Closure $callback
     * @return int
     */
    public function send($template, $to, $context = array(), \Closure $callback = null);
}
