<?php


namespace Fredtro\MailerBundle\Mailer;

use Fredtro\MailerBundle\Exception\InvalidBlocksException;
use Fredtro\MailerBundle\Exception\NoRecipientException;
use Fredtro\MailerBundle\Model\Mailer\Config;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


/**
 *
 * @author Frederik Trostorf <frederik.trostorf@ongoing.ch>
 *
 * Class Mailer
 */
class Mailer implements MailerInterface
{

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Mailer constructor.
     * @param \Twig_Environment $twig
     * @param \Swift_Mailer $mailer
     * @param EventDispatcherInterface $eventDispatcher
     * @param array $config
     */
    public function __construct(
        \Twig_Environment $twig,
        \Swift_Mailer $mailer,
        EventDispatcherInterface $eventDispatcher,
        array $config
    ) {
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->eventDispatcher = $eventDispatcher;
        $this->config = new Config($config);
    }

    /**
     * @param $template
     * @param $to
     * @param array $context
     * @param array $from
     * @param \Closure|null $callback
     * @return int
     * @throws \Exception
     * @throws \Throwable
     */
    public function sendMessage($template, $to, $context = array(), $from = array(), \Closure $callback = null)
    {
        if (empty($to)) {
            throw new NoRecipientException();
        }

        $loadedTemplate = $this->twig->load($template);
        $subject = $loadedTemplate->renderBlock('subject', $context);

        $message = (new \Swift_Message())
            ->setSubject($subject)
            ->setFrom(!empty($from) ? $from : $this->config->getFrom())
            ->setTo($to);

        $textBody = $this->renderTextBlock($loadedTemplate, $context);
        $htmlBody = $this->renderHtmlBlock($loadedTemplate, $context);

        $this->setBody($message, $textBody, $htmlBody);

        if ($callback instanceof \Closure) {
            $callback($message);
        }

        return $this->mailer->send($message);
    }

    /**
     * @param $context
     * @param $loadedTemplate
     * @return mixed
     */
    protected function renderTextBlock(\Twig_TemplateWrapper $loadedTemplate, array $context)
    {
        if ($loadedTemplate->hasBlock('text')) {
            return $loadedTemplate->renderBlock('text', $context);
        }
    }

    /**
     * @param array $context
     * @param $loadedTemplate
     * @return mixed
     */
    protected function renderHtmlBlock(\Twig_TemplateWrapper $loadedTemplate, array $context)
    {
        if ($loadedTemplate->hasBlock('html', $context)) {
            return $loadedTemplate->renderBlock('html', $context);
        }
    }

    /**
     * @param $htmlBody
     * @param $message
     * @param $textBody
     */
    protected function setBody(\Swift_Message $message, $textBody, $htmlBody)
    {
        if (empty($textBody) && empty($htmlBody)) {
            throw new InvalidBlocksException();
        }

        if (!empty($htmlBody)) {
            $message->setBody($htmlBody, 'text/html');
            if (!empty($textBody)) {
                $message->addPart($textBody)->addPart($textBody, 'text/plain');
            }
        } else {
            $message->setBody($textBody);
        }
    }
}