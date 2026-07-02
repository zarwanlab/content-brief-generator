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

        $prompt = "Act as a Senior SEO Expert and Content Strategist. Your task is to generate a detailed Content Brief for the keyword: \"{$keyword}\" in the language: {$language}.

CONTEXT/INSTRUCTIONS:
- Description: {$description}
- Competitors: {$competitors}
- Language: {$language}

STRICT OUTPUT RULES:
1. You MUST output ONLY a valid JSON object. 
2. DO NOT include any conversational text like \"I am ChatGPT\" or \"Here is your brief\".
3. DO NOT include markdown code blocks (```json).
4. All content must be in {$language}.

JSON STRUCTURE:
{
  \"h1_title\": \"(SEO optimized title)\",
  \"meta_description\": \"(Max 160 chars)\",
  \"structure\": [
    { \"heading\": \"Section Title\", \"tag\": \"H2/H3/H4\", \"description\": \"Detailed instructions for this section\" }
  ],
  \"lsi_keywords\": [\"keyword1\", \"keyword2\", ...],
  \"faq\": [
    { \"question\": \"Question?\", \"answer\": \"Answer...\" }
  ]
}";

        try {
            $baseUrl = env('AI_BASE_URL', 'https://ai.barivan.workers.dev/v1');
            $apiToken = env('AI_API_TOKEN');
            $model = env('AI_MODEL', 'gpt-oss-120b');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiToken,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->timeout(60)
            ->connectTimeout(10)
            ->retry(2, 200)
            ->post($baseUrl . '/chat/completions', [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are a professional Content Brief Generator. You always respond with pure JSON following the user's requested schema. No talking, no markdown, just JSON.",
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'temperature' => 0.3, // Lower temperature for more consistent JSON
                'max_tokens' => 2500,
                'stream' => false,
            ]);

            if ($response->successful()) {
                $content = trim($response->json('choices.0.message.content'));
                
                // Robust JSON extraction
                if (str_contains($content, '{')) {
                    $start = strpos($content, '{');
                    $end = strrpos($content, '}');
                    if ($start !== false && $end !== false) {
                        $content = substr($content, $start, $end - $start + 1);
                    }
                }
                
                $decoded = json_decode($content, true);
                
                if (json_last_error() !== JSON_ERROR_NONE || !isset($decoded['h1_title'])) {
                    // Log the bad content for debugging if needed
                    \Illuminate\Support\Facades\Log::error('AI Failed to provide JSON. Content: ' . $content);
                    return response()->json(['error' => 'The AI failed to generate a proper brief. Please try again.'], 500);
                }

                return response()->json($decoded);
            }

            $errorData = $response->json();
            $errorMessage = $errorData['error']['message'] ?? $response->body();
            return response()->json(['error' => 'AI Service Error: ' . $errorMessage], $response->status());
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return response()->json(['error' => 'Connection Timeout: The AI service took too long to respond.'], 504);
        } catch (\Exception $e) {
            return response()->json(['error' => 'System Error: ' . $e->getMessage()], 500);
        }
    }
}
