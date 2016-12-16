<?php

namespace Places\Controller\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use Places\Decoder\JsonDecoder;
use Places\Decoder\DecodeException;

/**
 * Register in the application some middlewares.
 */
class MiddlewareProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        /**
         * Decode the content of requests using JsonDecoder
         *
         * @todo  Check the validity of the request using Content-Type header
         * and its format. Implement a DecoderProvider as FOSRestBundle does.
         * (https://github.com/FriendsOfSymfony/FOSRestBundle/blob/master/Decoder/ContainerDecoderProvider.php)
         */
        $app->before(function(Request $request, Container $app) {

            $content = $request->getContent();

            if (!empty($content)) {
                $decoder = new JsonDecoder;

                try {
                    $data = $decoder->decode($content);
                } catch (DecodeException $e) {
                    throw new BadRequestHttpException($e->getMessage());
                }

                if (is_array($data)) {
                    $request->request = new ParameterBag($data);
                } else {
                    throw new BadRequestHttpException('Invalid message received');
                }
            }
        });
    }
}
