<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class C_Chatbot extends Controller
{
    // --- HALAMAN CHATBOT ---
    public function index()
    {
        if (!auth()->check() && !session('user_logged_in')) {
            return redirect()->route('login');
        }
        $conversation = session()->get('chatbot_conversation', []);
        return view('partials.V_ChatbotModal', compact('conversation'));
    }

    // --- PROSES KIRIM PESAN CHATBOT ---
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $conversation = session()->get('chatbot_conversation', []);
        $conversation[] = ['role' => 'user', 'content' => $request->message];
        $limitedConversation = array_slice($conversation, -10);
        session()->put('chatbot_conversation', $limitedConversation);

        $promptFile = storage_path('app/chatbot_prompt.json');
        $systemPrompt = 'Kamu adalah asisten AI dari SIMBRO...';
        
        if (file_exists($promptFile)) {
            $promptData = json_decode(file_get_contents($promptFile), true);
            if (isset($promptData['system_prompt'])) {
                $systemPrompt = $promptData['system_prompt'];
            }
        }

        $messages = array_merge(
            [['role' => 'system', 'content' => $systemPrompt]],
            $limitedConversation
        );

        try {
            $maxTokens = (int) config('groq.max_tokens', 1024);
            $temperature = (float) config('groq.temperature', 0.7);
            $model = config('groq.model', 'llama-3.1-8b-instant');
            $apiKey = config('groq.api_key');

            if (empty($apiKey)) {
                throw new \Exception('GROQ_API_KEY tidak dikonfigurasi');
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => $model,
                'messages' => $messages,
                'temperature' => $temperature,
                'max_tokens' => $maxTokens,
                'stream' => false,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $aiResponse = $data['choices'][0]['message']['content'] ?? 'Maaf, tidak ada respons dari AI.';

                $conversation[] = ['role' => 'assistant', 'content' => $aiResponse];
                $limitedConversation = array_slice($conversation, -10);
                session()->put('chatbot_conversation', $limitedConversation);

                return response()->json([
                    'success' => true,
                    'message' => $aiResponse,
                ]);
            }

            $errorBody = $response->json();
            $errorMessage = $errorBody['error']['message'] ?? 'Terjadi kesalahan pada server.';
            Log::error('Groq API Error: ' . $response->body());

            return response()->json([
                'success' => false,
                'message' => 'Maaf, terjadi kesalahan: ' . $errorMessage,
            ], 500);
        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Maaf, terjadi kesalahan pada server. Silakan coba lagi nanti.',
            ], 500);
        }
    }

    // --- HAPUS RIWAYAT PERCAKAPAN ---
    public function clearSession()
    {
        session()->forget('chatbot_conversation');
        return response()->json(['success' => true]);
    }
}
