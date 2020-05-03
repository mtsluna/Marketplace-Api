<?php


namespace App\EventSubscriber;

use App\Entity\Image;
use ApiPlatform\Core\EventListener\EventPriorities;
use ApiPlatform\Core\Util\RequestAttributesExtractor;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Vich\UploaderBundle\Storage\StorageInterface;

class ResolveImageContentUrlSubscriber implements EventSubscriberInterface
{

    private $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['onPreSerialize', EventPriorities::PRE_SERIALIZE],
        ];
    }

    public function onPreSerialize(ViewEvent $event): void
    {
        $controllerResult = $event->getControllerResult();
        $request = $event->getRequest();

        if ($controllerResult instanceof Response || !$request->attributes->getBoolean('_api_respond', true)) {
            return;
        }

        if (!($attributes = RequestAttributesExtractor::extractAttributes($request)) || !\is_a($attributes['resource_class'], Image::class, true)) {
            return;
        }

        $images = $controllerResult;

        if (!is_iterable($images)) {
            $images = [$images];
        }

        foreach ($images as $image) {
            if (!$image instanceof Image) {
                continue;
            }

            $image->url = $this->storage->resolveUri($image, 'file');
        }
    }

}