<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Helpers\ResponseHelper;
use App\Models\Blog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File as FileRule;

class BlogController extends Controller
{
    public function index(string $companyId)
    {
        try {
            $data = Blog::where('company_id', $companyId)->with('profile')->paginate(20);

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
            $data = Blog::where('blog_category_id', $categoryId)->with('profile')->paginate(20);

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

    public function create(Request $request, string $categoryId)
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
                'blog_category_id' => $categoryId,
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

    public function update(Request $request, string $id)
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

            $user = $request->user();

            $data = Blog::where('id', $id)->update([
                'blog_category_id' => $request->blog_category_id,
                'title' => $request->title,
                'body' => $request->body,
                'coverImg' => $coverImgUrl,
            ]);

            return ResponseHelper::make(
                'success',
                null,
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }

    public function delete(string $id)
    {
        try {
            $imgUrl = Blog::where('id', $id)->pluck('coverImg')->first();

            ImageHelper::delete($imgUrl);

            $data = Blog::where('id', $id)->delete();

            return ResponseHelper::make(
                'success',
                null,
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make('fail', null, $exception->getMessage());
        }
    }
}