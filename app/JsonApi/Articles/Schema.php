<?php

namespace App\JsonApi\Articles;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'articles';

    /**
     * @param \App\Models\Article $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Models\Article $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($article)
    {
        return [
            'title' => $article->title,
            'slug' => $article->slug,
            'content' => $article->content,
            'createdAt' => $article->created_at->toAtomString(),
            'updatedAt' => $article->updated_at->toAtomString(),
        ];
    }
    public function getRelationships($article, $isPrimary, array $includeRelationships)
    {
        return [
            'authors' => [
                // 'related' => true,
                // 'showSelf' => true,
                // 'showData' => isset($includeRelationships['authors']),
                // 'data' => function () use ($article) {
                //     return $article->user;
                // }
                self::SHOW_RELATED => true,
                self::SHOW_SELF => true,
                self::SHOW_DATA => isset($includeRelationships['authors']),
                self::DATA => function () use ($article) {
                    return $article->user;
                }
            ],
            'categories' => [
                self::SHOW_RELATED => true,
                self::SHOW_SELF => true,
                self::SHOW_DATA => isset($includeRelationships['categories']),
                self::DATA => function () use ($article) {
                    return $article->category;
                }
            ]
        ];
    }
}
