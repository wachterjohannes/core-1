<?php

namespace Nanbando\Core\Server\Command\Ssh;

/**
 * Indicates wrong ssh-configuration.
 */
class SshConfigurationException extends SshException
{
    /**
     * @var string
     */
    private $serverName;

    /**
     * @param string $serverName
     */
    public function __construct($serverName)
    {
        parent::__construct(sprintf('Server configuration "%s" is invalid.', $serverName));

        $this->serverName = $serverName;
    }

    /**
     * Returns serverName.
     *
     * @return string
     */
    public function getServerName()
    {
        return $this->serverName;
    }
}
