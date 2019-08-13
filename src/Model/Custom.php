<?php

namespace CultureKings\Afterpay\Model;

/**
 * Class Custom
 *
 * @package CultureKings\Afterpay\Custom
 */
class Custom
{
    /**
     * @var string
     */
    protected $sellerId;

    /**
     * Custom constructor.
     * @param string $sellerId
     */
    public function __construct($sellerId = "")
    {
        $this->setSellerId($sellerId);
    }

    /**
     * @return string
     */
    public function getSellerId(): string
    {
        return $this->sellerId;
    }

    /**
     * @param string $sellerId
     * @return $this
     */
    public function setSellerId(string $sellerId = "")
    {
        $this->sellerId = $sellerId;

        return $this;
    }
}
