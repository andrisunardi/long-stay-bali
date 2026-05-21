<?php

namespace App\Http\Controllers;

use App\Libraries\GoHighLevel;
use Illuminate\Http\Request;

class GoHighLevelController extends Controller
{
    public function oauth(Request $request)
    {
        (new GoHighLevel)->oauth(code: $request->query('code'));

        session()->flash('success', [
            'title' => trans('index.connect').' '.trans('index.success'),
            'message' => trans('page.oauth').' '.trans('message.has_been_successfully_connected'),
        ]);

        return redirect()->route('cms.home');
    }

    public function refresh()
    {
        (new GoHighLevel)->refresh();

        session()->flash('success', [
            'title' => trans('index.refresh').' '.trans('index.success'),
            'message' => trans('page.oauth').' '.trans('message.has_been_successfully_refreshed'),
        ]);

        return redirect()->route('cms.home');
    }
}
