<?php

namespace Tests\Mailer;

use Fredtro\MailerBundle\Mailer\Mailer;
use Fredtro\MailerBundle\Model\Mailer\Config;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 *
 * @author Frederik Trostorf <fredtrostorf@gmail.com>
 *
 * Class MailerTest
 */
class MailerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test sending with correct tpl
     */
    public function testSendMail()
    {
        $eventDispatcherMock = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcherMock->expects($this->exactly(6))->method('dispatch');

        $mailer = $this->getMailer($eventDispatcherMock);
        $this->assertEquals(1, $mailer->send('valid/template_html.twig', 'foo@example.com'));
        $this->assertEquals(1, $mailer->send('valid/template_html_text.twig', 'foo@example.com'));
        $this->assertEquals(1, $mailer->send('valid/template_text.twig', 'foo@example.com'));
    }

    /**
     * @expectedException \Fredtro\MailerBundle\Exception\NoRecipientException
     */
    public function testNoRecipientException()
    {
        $mailer = $this->getMailer($this->createMock(EventDispatcherInterface::class));
        $mailer->send('valid_template.twig', null);
    }

    /**
     * @expectedException \Fredtro\MailerBundle\Exception\BlockNotDefinedException
     */
    public function testInvalidBlocksException()
    {
        $mailer = $this->getMailer($this->createMock(EventDispatcherInterface::class));
        $mailer->send('invalid/template_missing_blocks.twig', 'foo@example.com');
    }

    /**
     * @param $eventDispatcherMock
     * @return Mailer
     */
    private function getMailer($eventDispatcherMock)
    {
        $twig = $this->getTwigEnvironment();
        $mailer = $this->getSwiftMailer();

        $config = ['foo@example.com'];

        return new Mailer($twig, $mailer, $eventDispatcherMock, new Config($config));
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
                $this->createMock(\Swift_Events_EventDispatcher::class)
            )
        );

        return $mailer;
    }

}