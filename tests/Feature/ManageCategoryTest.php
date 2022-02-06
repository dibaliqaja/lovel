<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_categories_page_contains_empty_categories_table()
    {
        $response = $this->get(route('categories.index'));
        $response->assertStatus(200);
        $response->assertSee('No categories found.');
    }

    public function test_categories_page_contains_non_empty_categories_table()
    {
        $category = Category::factory()->create();
        $response = $this->get(route('categories.index'));
        $response->assertStatus(200);
        $response->assertDontSee('No categories found.');
        $response->assertSee($category->name);
        $response->assertSee($category->slug);
    }
    public function test_user_can_see_category_create_button()
    {
        $response = $this->get(route('categories.index'));
        $response->assertStatus(200);
        $response->assertSee('Add New Category');
    }

    public function test_user_can_access_categories_create_page()
    {
        $response = $this->get(route('categories.create'));
        $response->assertStatus(200);
    }

    public function test_user_can_create_a_new_category()
    {
        $response = $this->post('categories', [
            'name' => 'New category',
        ]);
        $response->assertRedirect('categories');
        $this->assertDatabaseHas('categories', [
            'name' => 'New category',
            'slug' => 'new-category',
        ]);
        $category = Category::latest()->first();
        $this->assertEquals('New category', $category->name);
        $this->assertEquals('new-category', $category->slug);
    }

    public function test_validate_category_name_is_required()
    {
        $response = $this->post('categories', ['name' => '']);
        $response->assertSessionHasErrors('name');
    }

    public function test_validate_category_name_is_unique()
    {
        $category = Category::factory()->create();
        $response = $this->post('categories', ['name' => $category->name]);
        $response->assertSessionHasErrors('name');
    }

    public function test_user_can_access_categories_show_page()
    {
        $category = Category::factory()->create();
        $response = $this->get(route('categories.show', $category->id));
        $response->assertStatus(200);
        $response->assertSee($category->name);
        $response->assertSee($category->slug);
    }

    public function test_user_can_access_categories_edit_page()
    {
        $category = Category::factory()->create();
        $response = $this->get(route('categories.edit', $category->id));
        $response->assertStatus(200);
        $response->assertSee($category->name);
    }

    public function test_user_can_update_a_category()
    {
        $category = Category::factory()->create();
        $this->put(route('categories.update', $category->id),[
            'name' => 'Update category',
        ]);
        $this->assertDatabaseHas('categories', [
            'name' => 'Update category',
            'slug' => 'update-category',
        ]);
        $category = Category::latest()->first();
        $this->assertEquals('Update category', $category->name);
        $this->assertEquals('update-category', $category->slug);
    }

    public function test_user_can_delete_a_category()
    {
        $category = Category::factory()->create();
        $this->assertEquals(1, Category::count());
        $response = $this->delete('categories/' . $category->id);
        $response->assertStatus(302);
        $this->assertEquals(0, Category::count());
    }

    // /** @test */
    // public function validate_tag_title_is_not_more_than_60_characters()
    // {
    //     $this->loginAsUser();

    //     // title 70 characters
    //     $this->post(route('tags.store'), $this->getCreateFields([
    //         'title' => str_repeat('Test Title', 7),
    //     ]));
    //     $this->assertSessionHasErrors('title');
    // }

    // /** @test */
    // public function validate_tag_description_is_not_more_than_255_characters()
    // {
    //     $this->loginAsUser();

    //     // description 256 characters
    //     $this->post(route('tags.store'), $this->getCreateFields([
    //         'description' => str_repeat('Long description', 16),
    //     ]));
    //     $this->assertSessionHasErrors('description');
    // }

    // private function getEditFields(array $overrides = [])
    // {
    //     return array_merge([
    //         'title'       => 'Tag 1 title',
    //         'description' => 'Tag 1 description',
    //     ], $overrides);
    // }

    // /** @test */
    // public function user_can_edit_a_tag()
    // {
    //     $this->loginAsUser();
    //     $tag = Tag::factory()->create(['title' => 'Testing 123']);

    //     $this->visitRoute('tags.show', $tag);
    //     $this->click('edit-tag-'.$tag->id);
    //     $this->seeRouteIs('tags.edit', $tag);

    //     $this->submitForm(__('tag.update'), $this->getEditFields());

    //     $this->seeRouteIs('tags.show', $tag);

    //     $this->seeInDatabase('tags', $this->getEditFields([
    //         'id' => $tag->id,
    //     ]));
    // }

    // /** @test */
    // public function validate_tag_title_update_is_required()
    // {
    //     $this->loginAsUser();
    //     $tag = Tag::factory()->create(['title' => 'Testing 123']);

    //     // title empty
    //     $this->patch(route('tags.update', $tag), $this->getEditFields(['title' => '']));
    //     $this->assertSessionHasErrors('title');
    // }

    // /** @test */
    // public function validate_tag_title_update_is_not_more_than_60_characters()
    // {
    //     $this->loginAsUser();
    //     $tag = Tag::factory()->create(['title' => 'Testing 123']);

    //     // title 70 characters
    //     $this->patch(route('tags.update', $tag), $this->getEditFields([
    //         'title' => str_repeat('Test Title', 7),
    //     ]));
    //     $this->assertSessionHasErrors('title');
    // }

    // /** @test */
    // public function validate_tag_description_update_is_not_more_than_255_characters()
    // {
    //     $this->loginAsUser();
    //     $tag = Tag::factory()->create(['title' => 'Testing 123']);

    //     // description 256 characters
    //     $this->patch(route('tags.update', $tag), $this->getEditFields([
    //         'description' => str_repeat('Long description', 16),
    //     ]));
    //     $this->assertSessionHasErrors('description');
    // }

    // /** @test */
    // public function user_can_delete_a_tag()
    // {
    //     $this->loginAsUser();
    //     $tag = Tag::factory()->create();
    //     Tag::factory()->create();

    //     $this->visitRoute('tags.edit', $tag);
    //     $this->click('del-tag-'.$tag->id);
    //     $this->seeRouteIs('tags.edit', [$tag, 'action' => 'delete']);

    //     $this->press(__('app.delete_confirm_button'));

    //     $this->dontSeeInDatabase('tags', [
    //         'id' => $tag->id,
    //     ]);
    // }
}
