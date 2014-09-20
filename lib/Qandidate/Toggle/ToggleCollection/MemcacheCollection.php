<?php

/*
 * This file is part of the qandidate/toggle package.
 *
 * (c) Qandidate.com <opensource@qandidate.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Qandidate\Toggle\ToggleCollection;

use Qandidate\Toggle\Toggle;
use Qandidate\Toggle\ToggleCollection;

/**
 * Collection persisted in Memcache using the Memcached client.
 */
class MemcacheCollection extends ToggleCollection
{
    private $client;

    public function __construct(\Memcached $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritDoc}
     */
    public function all()
    {
        $keys = $this->client->getAllKeys();

        $toggles = array();

        foreach ($keys as $key) {
            $toggle = $this->getFromKey($key);

            $toggles[$toggle->getName()] = $toggle;
        }


        return $toggles;
    }

    /**
     * {@inheritDoc}
     */
    public function get($name)
    {
        return $this->getFromKey($name);
    }

    /**
     * {@inheritDoc}
     */
    public function set($name, Toggle $toggle)
    {
        $this->client->set($name, serialize($toggle));
    }

    /**
     * {@inheritDoc}
     */
    public function remove($name)
    {
        return $this->client->delete($name);
    }

    private function getFromKey($key)
    {
        $data = $this->client->get($key);

        if ( $this->client->getResultCode() == \Memcached::RES_NOTFOUND ) {
            return null;
        }

        return unserialize($data);
    }
}
