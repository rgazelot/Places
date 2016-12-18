<?php

namespace Places\Instagram;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;

use Places\Instagram\Entity\Media;
use Places\Instagram\Entity\MediaRepository;
use Places\Instagram\Entity\Location;
use Places\Instagram\Exception\ParseUrlException;

class Instagram
{
    private $client;
    private $mediaRepository;

    public function __construct(InstagramClient $client, MediaRepository $mediaRepository)
    {
        $this->client = $client;
        $this->mediaRepository = $mediaRepository;
    }

    public function getShortCodeFromRequest(Request $request)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $url = $accessor->getValue($request->request->all(), '[entry][0][messaging][0][message][text]');
        $url = trim($url, '/');
        $explode = explode('/', $url);
        $shortCode = array_pop($explode);

        if ('' === $shortCode || null === $shortCode) {
            throw new ParseUrlException('shortCode cannot be empty or null.');
        }

        return $shortCode;
    }

    public function getMediaFromShortCode($shortCode)
    {
        $clientResponse = $this->client->getMediaFromShortCode($shortCode);

        // A factory that could check the array's property could be used here.

        $location = new Location;
        $location->setId($clientResponse['data']['location']['id']);
        $location->setName($clientResponse['data']['location']['name']);
        $location->setLatitude($clientResponse['data']['location']['latitude']);
        $location->setLongitude($clientResponse['data']['location']['longitude']);

        $media = new Media;
        $media->setId($clientResponse['data']['id']);
        $media->setLocation($location);
        $media->setImages($clientResponse['data']['images']);

        return $media;
    }

    public function persist(Media $media)
    {
        $this->mediaRepository->persist($media);
    }
}
