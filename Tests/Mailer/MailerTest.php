<?php

namespace Tests\Mailer;

use Fredtro\MailerBundle\Mailer\Mailer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MailerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test sending with correct tpl
     */
    public function testSendMail()
    {
        $mailer = $this->getMailer();
        $this->assertEquals(1, $mailer->sendMessage('valid/template_html.twig', 'foo@example.com'));
        $this->assertEquals(1, $mailer->sendMessage('valid/template_html_text.twig', 'foo@example.com'));
        $this->assertEquals(1, $mailer->sendMessage('valid/template_text.twig', 'foo@example.com'));
    }

    /**
     * @expectedException \Fredtro\MailerBundle\Exception\NoRecipientException
     */
    public function testNoRecipientException()
    {
        $mailer = $this->getMailer();
        $mailer->sendMessage('valid_template.twig', null);
    }

    /**
     * @expectedException \Fredtro\MailerBundle\Exception\InvalidBlocksException
     */
    public function testInvalidBlocksException()
    {
        $mailer = $this->getMailer();
        $mailer->sendMessage('invalid/template_missing_blocks.twig', 'foo@example.com');
    }

    /**
     * @return Mailer
     */
    private function getMailer()
    {
        $twig = $this->getTwigEnvironment();
        $mailer = $this->getSwiftMailer();
        $eventDispatcherMock = \Mockery::mock(EventDispatcherInterface::class)->shouldIgnoreMissing();
        $config = ['foo@example.com'];

        return new Mailer($twig, $mailer, $eventDispatcherMock, $config);
    }

    /**
     * @return \Twig_Environment
     */
    private function getTwigEnvironment()
    {
        return new \Twig_Environment(new \Twig_Loader_Filesystem(__DIR__ ."/fixtures"));
    }

    /**
     * @return \Swift_Mailer
     */
    private function getSwiftMailer()
    {
        $mailer = new \Swift_Mailer(
            new \Swift_Transport_NullTransport(
                \Mockery::mock(\Swift_Events_EventDispatcher::class)->shouldIgnoreMissing()
            )
        );

        return $mailer;
    }

}