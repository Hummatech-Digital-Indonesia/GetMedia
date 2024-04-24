<?php

namespace App\Services;

use App\Models\Tag;
use App\Models\News;
use App\Models\NewsTag;
use App\Models\NewsPhoto;
use App\Traits\UploadTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Enums\UploadDiskEnum;
use App\Helpers\ImageCompressing;
use App\Http\Requests\NewsRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\NewsUpdateRequest;
use function Laravel\Prompts\multisearch;
use App\Http\Requests\Dashboard\Article\UpdateRequest;

use App\Base\Interfaces\uploads\CustomUploadValidation;
use App\Base\Interfaces\uploads\ShouldHandleFileUpload;

class NewsService implements ShouldHandleFileUpload, CustomUploadValidation
{
    use UploadTrait;

    /**
     * Handle custom upload validation.
     *
     * @param string $disk
     * @param object $file
     * @param string|null $old_file
     * @return string
     */
    public function validateAndUpload(string $disk, object $file, string $old_file = null): string
    {
        if ($old_file) $this->remove($old_file);

        return $this->upload($disk, $file);
    }

    /**
     * Handle store data event to models.
     *
     * @param StoreRequest $request
     *
     * @return array|bool
     */
    public function store(NewsRequest $request)
    {
        // dd($request);
        $data = $request->validated();

        if ($request->has('tags')) {
            $newTags = [];
            foreach ($request->input('tags') as $tagName) {
                $tag = Tag::updateOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName)]
                );
                $newTags[] = $tag->id;
            }

            $data['tags'] = $newTags;
        }

        $multi_photo = [];
            if ($request->hasFile('multi_photo')) {
                foreach ($request->file('multi_photo') as $image) {
                    $stored_image = $image->store(UploadDiskEnum::NEWS_PHOTO->value , 'public');
                    $multi_photo[] = $stored_image;
                }
            }

            $image = $this->upload(UploadDiskEnum::NEWS->value, $request->file('photo'));

            $domQuestion = new \DOMDocument();
            libxml_use_internal_errors(true);
            $domQuestion->loadHTML($data['content'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NOIMPLIED);
            $this->processImages($domQuestion);

            libxml_clear_errors();

        return [
            'author_id' => auth()->user()->author->id,
            'name' => $data['name'],
            'photo' => $image,
            'multi_photo' => $multi_photo,
            'content' => $domQuestion->saveHTML(),
            'slug' => Str::slug($data['name']),
            'category' => $data['category'],
            'sub_category' => $data['sub_category'],
            'tags' => $data['tags'],
            'upload_date' => $data['upload_date']
        ];
    }

    /**
     * Handle update data event to models.
     *
     * @param UpdateRequest $request
     * @param Article $article
     * @return array|bool
     */

    public function update(NewsUpdateRequest $request, News $news, NewsPhoto $newsPhoto): array|bool
    {
        $data = $request->validated();

        if ($request->has('tags')) {
            $newTags = [];
            foreach ($request->input('tags') as $tagName) {
                $tag = Tag::updateOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName)]
                );
                $newTags[] = $tag->id;
            }

            $data['tags'] = $newTags;
        }

        $old_photo = $news->photo;
        $new_photo= "";

        $old_multi_photo = $newsPhoto->where('news_id', $news->id)->pluck('multi_photo')->toArray();
        $new_multi_photo = [];

        if ($request->hasFile('multi_photo')) {
            foreach ($request->file('multi_photo') as $image) {
                $this->remove($image);
                $stored_image = $image->store(UploadDiskEnum::NEWS_PHOTO->value , 'public');
                $new_multi_photo[] = $stored_image;
            }
        }


        if ($request->hasFile('photo')) {
            $this->remove($old_photo);
            $new_photo = $this->upload(UploadDiskEnum::NEWS->value, $request->file('photo'));
        }


        $id = "";
        if (auth()->user()->roles->pluck('name')->contains("admin")) {
            $id = $news->author_id;
        } else {
            $id = auth()->user()->author->id;
        }

        return [
            'author_id' => $id,
            'name' => $data['name'],
            'photo' => $old_photo ?: $new_photo,
            'multi_photo' => $new_multi_photo ?: $old_multi_photo,
            'content' => $data['content'],
            'slug' => Str::slug($data['name']),
            'category' => $data['category'],
            'tags' => $data['tags'],
            'upload_date' => $data['upload_date'],
            'sub_category' => $data['sub_category'],
        ];
    }

    public function updateByAdmin(NewsUpdateRequest $request, News $news, NewsPhoto $newsPhoto): array|bool
    {
        $data = $request->validated();

        if ($request->has('tags')) {
            $newTags = [];
            foreach ($request->input('tags') as $tagName) {
                $tag = Tag::updateOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName)]
                );
                $newTags[] = $tag->id;
            }

            $data['tags'] = $newTags;
        }

        $old_photo = $news->photo;
        $new_photo= "";

        $old_multi_photo = $newsPhoto->where('news_id', $news->id)->pluck('multi_photo')->toArray();
        $new_multi_photo = [];

        if ($request->hasFile('multi_photo')) {
            foreach ($request->file('multi_photo') as $image) {
                $this->remove($image);
                $stored_image = $image->store(UploadDiskEnum::NEWS_PHOTO->value , 'public');
                $new_multi_photo[] = $stored_image;
            }
        }

        if ($request->hasFile('photo')) {
            $this->remove($old_photo);
            $new_photo = $this->upload(UploadDiskEnum::NEWS->value, $request->file('photo'));
        }

        return [
            'author_id' => $news->author->id,
            'name' => $data['name'],
            'photo' => $old_photo ?: $new_photo,
            'multi_photo' => $new_multi_photo ?: $old_multi_photo,
            'content' => $data['content'],
            'slug' => Str::slug($data['name']),
            'category' => $data['category'],
            'tags' => $data['tags'],
            'upload_date' => $data['upload_date'],
            'sub_category' => $data['sub_category'],
        ];
    }

    private function processImages(\DOMDocument $dom)
    {
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            if (preg_match('#data:image/#', $src)) {
                preg_match('#data:image/(?<mime>.*?)\;#', $src, $groups);
                $mimetype = $groups['mime'];
                $fileNameContent = uniqid();
                $fileNameContentRand = substr(md5($fileNameContent), 6, 6) . '_' . time();
                $filepath = $fileNameContentRand . '.' . $mimetype;
        
                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $src));
        
                Storage::put(UploadDiskEnum::CONTENT->value . '/' . $filepath, $imageData);
        
                $baseUrl = config('app.url');

                $new_src = str_replace('http://127.0.0.1:8000', $baseUrl, Storage::url(UploadDiskEnum::CONTENT->value . '/' . $filepath));
                
                $img->removeAttribute('src');
                $img->setAttribute('src', $new_src);
                $img->setAttribute('class', 'img-responsive');
            }
        }
        
    }
}
