<?php

namespace App\Http\Controllers;

use App\Events\MessageCreated;
use App\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $messages = Message::with(['user'])->get();
        return response()->json($messages);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $message = $request->user()->messages()->create([
            'body' => $request->body
        ]);

        broadcast(new MessageCreated($message))->toOthers();

        return response()->json($message);
    }
}
