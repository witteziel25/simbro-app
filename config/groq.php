<?php

return [
    'api_key' => env('GROQ_API_KEY'),
    'model' => env('GROQ_MODEL', 'llama-3.1-8b-instant'),
    'temperature' => (float) env('GROQ_TEMPERATURE', 0.7),
    'max_tokens' => (int) env('GROQ_MAX_TOKENS', 1024),
];
