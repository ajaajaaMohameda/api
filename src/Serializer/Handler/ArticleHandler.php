<?php

use App\Entity\Article;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\SerializationContext as Context;

class ArticleHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => Article::class,
                'method' => 'serialize'
            ],
            [
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => 'json',
                'type' => Article::class,
                'method' => 'deserialize'
            ]
        ];
    }

    public function serialize(JsonSerializationVisitor $visitor, Article $article, array $type, Context $context)
    {
        // L'on reçoit un objet à sérialiser (dans cet exemple, $article)
        // Puis nous pouvons manipuler le graph d'objet grâce à l'objet $visitor 

        $date = new \DateTime();
        $data = [
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'delivered_at' => $date->format('l jS \of F Y h:i:s A')
        ];

        return $visitor->visitArray($data, $type, $context);
    }

    public function deserialize(JsonDeserializationVisitor $visitor, $data)
    {
        // Dans cet exemple, la méthode doit retourner un objet de type AppBundle\Entity\Article

        return new Article($data);
    }
}
