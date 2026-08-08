<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AiChatController extends Controller
{
    /**
     * AI Chatbot Feature Disabled (Returns 404 Not Found)
     */
    public function respond(Request $request)
    {
        abort(404);
    }
}
