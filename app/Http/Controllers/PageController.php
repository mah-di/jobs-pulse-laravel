<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Helpers\ResponseHelper;
use App\Mail\ContactMail;
use App\Models\Page;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

    public function validateDescription(Request $request)
    {
        if ($request->type === 'Home') {
            return $request->validate([
                'recentJobsHeading' => ['required'],
            ]);
        }
        if ($request->type === 'Job-Listing') {
            return [];
        }
        if ($request->type === 'Blogs') {
            return $request->validate([
                'categoryTitle' => ['required'],
            ]);
        }
        if ($request->type === 'Single-Blog') {
            return $request->validate([
                'categoryTitle' => ['required'],
            ]);
        }
        if ($request->type === 'About') {
            return $request->validate([
                'subHeading' => ['required'],
                'heading' => ['required'],
                'shortDesc' => ['required'],
                'longDesc' => ['required'],
            ]);
        }
        if ($request->type === 'Contact') {
            return $request->validate([
                'heading' => ['required'],
                'city' => ['required'],
                'state' => ['required'],
                'area' => ['required'],
                'house' => ['required'],
                'contact' => ['required'],
                'activeHours' => ['required'],
                'email' => ['required'],
            ]);
        }
    }

    public function save(Request $request)
    {
        try {
            $request->validate([
                'type' => ['required', 'in:Home,Job-Listing,Blogs,Single-Blog,About,Contact'],
                'title' => ['required'],
                'coverImg' => ['required'],
                'image' => ['nullable', FileRule::image()->max(10240)],
            ]);

            $coverImg = $request->coverImg;
            $data = $this->validateDescription($request);

            if ($request->hasFile('image')) {
                ImageHelper::delete($coverImg);
                $coverImg = ImageHelper::save($request->file('image'), 'assets/img/hero', strtolower($request->type));
            }

            Page::where('type', $request->type)->update([
                'title' => $request->title,
                'description' => $data,
                'coverImg' => $coverImg
            ]);

            return ResponseHelper::make(
                'success',
                null,
                "{$request->type} page information updated!"
            );

        } catch (Exception $exception) {
            return ResponseHelper::make(
                'fail',
                null,
                $exception->getMessage()
            );
        }
    }

    public function sendContactMail(Request $request)
    {
        try {
            $request->validate([
                'email' =>['required', 'email'],
                'message' => ['required'],
            ]);

            Mail::to('support@jobspulse.com')->send(new ContactMail($request->name, $request->email, $request->subject, $request->message));

            return ResponseHelper::make(
                'fail',
                null,
                'Mail sent. Our support team will contact you soon!'
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
