<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BriefController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string',
            'language' => 'required|string',
            'description' => 'nullable|string',
            'competitors' => 'nullable|string',
        ]);

        $keyword = $request->input('keyword');
        $language = $request->input('language');
        $description = $request->input('description');
        $competitors = $request->input('competitors');

        $prompt = "You are a senior SEO strategist. Generate a comprehensive Content Brief in {$language} for the following keyword: \"{$keyword}\".
        
Context: {$description}
Competitor URLs: {$competitors}

The output must be a structured JSON object with exactly these keys:
- h1_title: A catchy, SEO-optimized H1 title.
- meta_description: A compelling meta description (max 160 chars).
- structure: An array of objects, each with 'heading' (H2/H3) and 'description' (what to cover in this section).
- lsi_keywords: An array of 10-15 LSI keywords.
- faq: An array of objects, each with 'question' and 'answer'.

Format the response ONLY as valid JSON.";

        try {
            $baseUrl = env('AI_BASE_URL', 'https://ai.barivan.workers.dev/v1');
            $apiToken = env('AI_API_TOKEN');
            $model = env('AI_MODEL', 'gpt-oss-120b');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiToken,
                'Content-Type' => 'application/json',
            ])->post($baseUrl . '/chat/completions', [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'temperature' => 0.7,
                'max_tokens' => 2048,
                'stream' => false,
            ]);

            if ($response->successful()) {
                $content = $response->json('choices.0.message.content');
                // Attempt to clean JSON if AI wraps it in markdown code blocks
                if (preg_match('/```json\s*(.*?)\s*```/s', $content, $matches)) {
                    $content = $matches[1];
                }
                
                return response()->json(json_decode($content, true));
            }

            return response()->json(['error' => 'API Error: ' . $response->body()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }
}
