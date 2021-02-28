<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class includeArticlesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_include_articles()
    {
        $category = Category::factory()
            ->hasArticles()
            ->create();

        $this->jsonApi()
            ->includePaths('articles')
            ->get(route('api.v1.categories.read', $category))
            ->assertSee($category->articles[0]->title)
            ->assertJsonFragment([
                'related' => route('api.v1.categories.relationships.articles', $category)
            ])
            ->assertJsonFragment([
                'self' => route('api.v1.categories.relationships.articles.read', $category)
            ]);
    }
    /** @test */
    public function can_fetch_related_articles()
    {
        $category = Category::factory()
            ->hasArticles()
            ->create();

        $this->jsonApi()
            ->get(route('api.v1.categories.relationships.articles', $category))
            ->assertSee($category->articles[0]->title);

        $this->jsonApi()
            ->get(route('api.v1.categories.relationships.articles.read', $category))
            ->assertSee($category->articles[0]->getRouteKey());
    }
}
