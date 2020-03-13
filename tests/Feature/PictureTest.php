<?php

namespace Tests\Feature;

use App\Gallery;
use App\Picture;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PictureTest extends TestCase
{
    use RefreshDatabase;

    public function testAMemberCanNotEditAPicture()
    {
        $member = factory(User::class)->create();
        $picture = factory(Picture::class)->create();

        $response = $this->actingAs($member)->patch(route('pictures.update', ['picture' => $picture->id]), [
            'is_private' => true,
        ]);

        $response->assertRedirect(route('index'));
        $response->assertSessionHas('error', 'Je kunt deze actie alleen als beheerder uitvoeren');

        $this->assertEquals($picture->fresh()->is_private, 0);
    }

    public function testAPictureCanBeEditedByAnAdmin()
    {
        $admin = factory(User::class)->create(['role' => 'admin']);
        $picture = factory(Picture::class)->create();

        $response = $this->actingAs($admin)->patch(route('pictures.update', ['picture' => $picture->id]), [
            'is_private' => true,
        ]);

        $updated_picture = Picture::first();

        $response->assertRedirect(route('galleries.show', ['gallery' => $picture->gallery->title]));
        $response->assertSessionHas('success', 'Foto is bijgewerkt');

        $this->assertEquals($updated_picture->is_private, true);
    }

    public function testAPictureCanBeMadeFeatured()
    {
        $this->withoutExceptionHandling();

        $admin = factory(User::class)->create(['role' => 'admin']);
        $picture = factory(Picture::class)->create();

        $response = $this->actingAs($admin)->patch(route('pictures.update', ['picture' => $picture->id]), [
            'is_featured' => true,
        ]);

        $response->assertRedirect(route('galleries.show', ['gallery' => $picture->gallery->title]));
        $response->assertSessionHas('success', 'Foto is bijgewerkt');

        $this->assertEquals($picture->fresh()->is_featured, 1);
    }

    public function testFeaturedImagesCanBeQueriedFromTheirGallery()
    {
        $gallery = factory(Gallery::class)->create();
        $pictures = [];
        for ($i = 0; $i < 3; $i++) {
            $pictures[] = factory(Picture::class)->create(['gallery_id' => $gallery->id, 'is_featured' => true]);
        }

        $this->assertCount(3, $gallery->featuredPictures());
    }

    public function testAGalleryCanOnlyHaveThreeFeaturedPictures()
    {
        $gallery = factory(Gallery::class)->create();
        for ($i = 0; $i < 3; $i++) {
            factory(Picture::class)->create(['gallery_id' => $gallery->id, 'is_featured' => true]);
        }

        $admin = factory(User::class)->create(['role' => 'admin']);
        $picture = factory(Picture::class)->create(['gallery_id' => $gallery->id]);

        $response = $this->actingAs($admin)->patch(route('pictures.update', ['picture' => $picture->id]), [
            'is_featured' => true,
        ]);

        $response->assertRedirect(route('galleries.show', ['gallery' => $picture->gallery->title]));
        $response->assertSessionHas(
            'error',
            'Deze gallerij heeft al 3 uitgelichte foto\'s, verander eerst een foto naar niet uitgelicht'
        );

        $this->assertEquals($picture->fresh()->is_featured, 0);
    }
}
