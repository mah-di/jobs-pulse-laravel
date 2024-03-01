<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Helpers\ResponseHelper;
use App\Models\Page;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File as FileRule;

class PageController extends Controller
{
    public function show(string $type)
    {
        try {
            $data = Page::where('type', $type)->first();

            return ResponseHelper::make(
                'success',
                $data
            );

        } catch (Exception $exception) {
            return ResponseHelper::make(
                'fail',
                null,
                $exception->getMessage()
            );
        }
    }

    public function saveAbout(Request $request)
    {
        try {
            $request->validate([
                'title' => ['required'],
                'coverImg' => ['required'],
                'image' => ['nullable', FileRule::image()->max(10240)],
            ]);

            $coverImg = $request->coverImg;
            $data = $request->validate([
                'subHeading' => ['required'],
                'heading' => ['required'],
                'shortDesc' => ['required'],
                'longDesc' => ['required'],
            ]);

            if ($request->hasFile('image')) {
                ImageHelper::delete($coverImg);
                $coverImg = ImageHelper::save($request->file('image'), 'assets/hero', 'about');
            }

            Page::where('type', 'About')->update([
                'title' => $request->title,
                'description' => $data,
                'coverImg' => $coverImg
            ]);

            return ResponseHelper::make(
                'success',
                null,
                'About page information updated!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make(
                'fail',
                null,
                $exception->getMessage()
            );
        }
    }

    public function saveContact(Request $request)
    {
        try {
            $request->validate([
                'title' => ['required'],
                'coverImg' => ['required'],
                'image' => ['nullable', FileRule::image()->max(10240)],
            ]);

            $coverImg = $request->coverImg;
            $data = $request->validate([
                'heading' => ['required'],
                'city' => ['required'],
                'state' => ['required'],
                'area' => ['required'],
                'house' => ['required'],
                'contact' => ['required'],
                'activeHours' => ['required'],
                'email' => ['required'],
            ]);

            if ($request->hasFile('image')) {
                ImageHelper::delete('assets/img/hero/contact.jpg');
                $coverImg = ImageHelper::save($request->file('image'), 'assets/img/hero', 'contact');
            }

            Page::where('type', 'Contact')->update([
                'title' => $request->title,
                'description' => $data,
                'coverImg' => $coverImg
            ]);

            return ResponseHelper::make(
                'success',
                null,
                'Contact page information updated!'
            );

        } catch (Exception $exception) {
            return ResponseHelper::make(
                'fail',
                null,
                $exception->getMessage()
            );
        }
    }
}
