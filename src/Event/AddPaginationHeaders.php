<?php

declare(strict_types=1);
namespace App\Event;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class AddPaginationHeaders implements EventSubscriberInterface
{
    public function addHeaders(ResponseEvent $event): void
    {
        $request = $event->getRequest();

        if (($data = $request->attributes->get('data')) && $data instanceof Paginator) {
            $from = $data->count() ? ($data->getCurrentPage() - 1) * $data->getItemsPerPage() : 0;
            $to = $data->getCurrentPage() < $data->getLastPage() ? $data->getCurrentPage() * $data->getItemsPerPage() : $data->getTotalItems();
            $lastPage = $data->getLastPage();
            $currentPage = $data->getCurrentPage();

            $response = $event->getResponse();
            $response->headers->add([
                'Content-Range' => \sprintf('%u-%u/%u', $from, $to, $data->getTotalItems()),
                'Page-Range' => \sprintf('%u/%u', $currentPage, $lastPage),
                'Access-Control-Expose-Headers' => 'Page-Range, Content-Range'
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'addHeaders',
        ];
    }
}