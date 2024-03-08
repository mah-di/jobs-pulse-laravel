<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Helpers\ResponseHelper;
use App\Models\Blog;
use App\Models\BlogCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File as FileRule;

class BlogController extends Controller
{
    public function index()
    {
        try {
            $data = Blog::latest()->with(['profile', 'category'])->paginate(20);

            return ResponseHelper::make(
                'success',
                $data,
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function indexByUser(string $profileId)
    {
        try {
            $data = Blog::latest()->where('profile_id', $profileId)->with(['profile', 'category'])->paginate(5);

            return ResponseHelper::make(
                'success',
                $data,
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function indexByCompany(string $companyId)
    {
        try {
            if ($companyId === '0')
                $data = Blog::latest()->where('company_id', null)->with(['profile', 'category'])->paginate(5);
            else
                $data = Blog::latest()->where('company_id', $companyId)->with(['profile', 'category'])->paginate(5);

            return ResponseHelper::make(
                'success',
                $data,
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function indexByCategory(string $categoryId)
    {
        try {
            $data = Blog::latest()->where('blog_category_id', $categoryId)->with(['profile', 'category'])->paginate(5);

            return ResponseHelper::make(
                'success',
                $data,
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $data = Blog::with(['company', 'category', 'profile'])->find($id);

            return ResponseHelper::make(
                'success',
                $data,
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function create(Request $request, BlogCategory $category)
    {
        try {
            $request->validate([
                'title' => ['required', 'string'],
                'body' => ['required', 'string'],
                'image' => ['nullable', FileRule::image()->max(2048)],
            ]);

            $coverImgUrl = env('DEFAULT_BLOG_COVER_IMG');

            if ($request->hasFile('image'))
                $coverImgUrl = ImageHelper::save($request->file('image'), 'blog-covers');

            $user = $request->user();

            $data = Blog::create([
                'company_id' => $user->company_id,
                'profile_id' => $user->profile()->pluck('id')->first(),
                'blog_category_id' => $category->id,
                'title' => $request->title,
                'body' => $request->body,
                'coverImg' => $coverImgUrl,
            ]);

            return ResponseHelper::make(
                'success',
                $data,
                'Blog posted!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function update(Request $request, Blog $blog)
    {
        try {
            $request->validate([
                'blog_category_id' => ['required'],
                'title' => ['required', 'string'],
                'body' => ['required', 'string'],
                'image' => ['nullable', FileRule::image()->max(2048)],
                'coverImg' => ['required', 'string'],
            ]);

            $coverImgUrl = $request->coverImg;

            if ($request->hasFile('image')) {
                ImageHelper::delete($coverImgUrl);

                $coverImgUrl = ImageHelper::save($request->file('image'), 'blog-covers');
            }

            $blog->update([
                'blog_category_id' => $request->blog_category_id,
                'title' => $request->title,
                'body' => $request->body,
                'coverImg' => $coverImgUrl,
            ]);

            return ResponseHelper::make(
                'success',
                null,
                'Blog updated!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function delete(Blog $blog)
    {
        try {
            ImageHelper::delete($blog->coverImg);

            $blog->delete();

            return ResponseHelper::make(
                'success',
                null,
                'Blog deleted!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
}
