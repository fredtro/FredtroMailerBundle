<?php


namespace Fredtro\MailerBundle\Model\Mailer;


/**
 *
 * @author Frederik Trostorf <frederik.trostorf@ongoing.ch>
 *
 * Class Config
 */
class Config
{
    /**
     * @var array
     */
    protected $from;

    /**
     * Config constructor.
     * @param array $from
     */
    public function __construct(array $from)
    {
        $this->from = $from;
    }

    /**
     * @return array
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param $from
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }
}