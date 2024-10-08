<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Spatie\Tags\Tag;

class TagController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request)
    {
        $query = $request->input('q');

        $tagsQuery = Tag::query();
        if ($query) {
            $tagsQuery->where('name', 'like', '%' . $query . '%');
        }

        $tags = $tagsQuery->pluck('name');

        return $this->apiSuccess(compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tag = Tag::findOrCreate($request->input('name'));

        return response()->json($tag, 201);
    }
}