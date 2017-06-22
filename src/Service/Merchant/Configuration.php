<?php
namespace CultureKings\Afterpay\Service\Merchant;

use CultureKings\Afterpay\Exception\ApiException;
use CultureKings\Afterpay\Model\ErrorResponse;
use CultureKings\Afterpay\Model\Merchant\Authorization;
use CultureKings\Afterpay\Model\Merchant\Configuration as ConfigurationModel;
use CultureKings\Afterpay\Traits;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use JMS\Serializer\SerializerInterface;

/**
 * Class Configuration
 *
 * @package CultureKings\Afterpay\Service\Merchant
 */
class Configuration
{
    use Traits\AuthorizationTrait;
    use Traits\ClientTrait;
    use Traits\SerializerTrait;

    /**
     * Configuration constructor.
     *
     * @param ClientInterface     $client
     * @param Authorization       $authorization
     * @param SerializerInterface $serializer
     */
    public function __construct(
        ClientInterface $client,
        Authorization $authorization,
        SerializerInterface $serializer
    ) {
        $this->setClient($client);
        $this->setAuthorization($authorization);
        $this->setSerializer($serializer);
    }

    /**
     * @return array
     */
    public function get()
    {
        try {
            $result = $this->getClient()->get(
                'configuration',
                [
                    'auth' => [
                        $this->getAuthorization()->getMerchantId(),
                        $this->getAuthorization()->getSecret(),
                    ],
                ]
            );
        } catch (BadResponseException $exception) {
            throw new ApiException(
                $this->getSerializer()->deserialize(
                    (string) $exception->getResponse()->getBody(),
                    ErrorResponse::class,
                    'json'
                ),
                $exception
            );
        }

        return $this->getSerializer()->deserialize(
            (string) $result->getBody(),
            sprintf('array<%s>', ConfigurationModel::class),
            'json'
        );
    }
}
