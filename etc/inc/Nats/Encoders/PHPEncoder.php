<?php
/**
 * Copyright © MIKO LLC - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Alexey Portnov, 2 2020
 */

namespace Nats\Encoders;

/**
 * Class PHPEncoder
 *
 * Encodes and decodes messages in PHP format.
 *
 * @package Nats
 */
class PHPEncoder implements Encoder
{


    /**
     * Encodes a message to PHP.
     *
     * @param string $payload Message to decode.
     *
     * @return mixed
     */
    public function encode($payload)
    {
        $payload = serialize($payload);
        return $payload;
    }

    /**
     * Decodes a message from PHP.
     *
     * @param string $payload Message to decode.
     *
     * @return mixed
     */
    public function decode($payload)
    {
        $payload = unserialize($payload);
        return $payload;
    }
}
