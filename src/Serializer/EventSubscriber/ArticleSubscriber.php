<?php

namespace App\Serializer\EventSubscriber;

use App\Entity\Article;
use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\Metadata\StaticPropertyMetadata;

class ArticleSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            [
                'event' => Events::POST_SERIALIZE,
                'format' => 'json',
                'class' => Article::class,
                'method' => 'onPostSerialize'
            ]
        ];
    }

    public static function onPostSerialize(ObjectEvent $event)
    {
        // possibilite de recuperer l'objet qui a ete serialize
        $object = $event->getObject();

        $date = new \DateTime();
        // Possibilité de modifier le tableau après sérialisation
    }
}