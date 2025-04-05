<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MistralAIService
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = env('HUGGINGFACE_API_KEY');
        $this->apiUrl = 'https://api-inference.huggingface.co/models/facebook/bart-large-cnn';
    }

    public function generateProductDescription($category, $productName)
    {
        try {
            $prompt = "Rédige une fiche produit réaliste au format JSON pour un article nommé \"{$productName}\" appartenant à la catégorie \"{$category}\".
Les champs requis sont : 
- design : le nom exact du produit
- prix : un prix réaliste en euros
- description : une description marketing
- quantite : un stock approximatif
- categorie : la catégorie du produit
Retourne uniquement le JSON.";

            // If running locally without API key, use fallback
            if (app()->environment('local') && empty($this->apiKey)) {
                return $this->getFallbackProduct($category, $productName);
            }

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => env('APP_ENV') === 'local' ? false : true // Only disable verification in local
            ])->post($this->apiUrl, [
                'inputs' => $prompt,
                'parameters' => [
                    'temperature' => 0.7,
                    'top_p' => 0.9,
                    'max_new_tokens' => 400,
                    'return_full_text' => false,
                ]
            ]);

            if (!$response->successful()) {
                Log::error("API Error: " . $response->body());
                return $this->getFallbackProduct($category, $productName);
            }

            $generated = $response->json();
            $text = $generated[0]['generated_text'] ?? null;

            if (!$text) {
                Log::error("No text generated");
                return $this->getFallbackProduct($category, $productName);
            }

            preg_match('/\{.*\}/s', $text, $matches);
            if (empty($matches)) {
                Log::error("JSON not found in response: " . $text);
                return $this->getFallbackProduct($category, $productName);
            }

            $jsonData = json_decode($matches[0], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error("JSON Error: " . json_last_error_msg() . " | Text: " . $matches[0]);
                return $this->getFallbackProduct($category, $productName);
            }

            return $jsonData;

        } catch (\Exception $e) {
            Log::error("AI Service Error: " . $e->getMessage());
            return $this->getFallbackProduct($category, $productName);
        }
    }

    /**
     * Get a fallback product when the API fails
     */
    private function getFallbackProduct($category, $productName)
    {
        $descriptions = [
            "Ce produit de haute qualité est conçu pour répondre à toutes vos attentes. Avec son design élégant et ses fonctionnalités avancées, il deviendra rapidement indispensable dans votre quotidien.",
            "Découvrez notre {$productName}, l'innovation parfaite pour les amateurs de {$category}. Sa conception robuste et ses performances exceptionnelles vous garantissent une satisfaction durable.",
            "Le {$productName} représente l'alliance parfaite entre technologie de pointe et facilité d'utilisation. Son rapport qualité-prix imbattable en fait un choix judicieux pour tous les budgets."
        ];

        return [
            'design' => $productName,
            'description' => $descriptions[array_rand($descriptions)],
            'prix' => number_format(rand(1999, 29999) / 100, 2),
            'quantite' => rand(5, 50),
            'categorie' => $category
        ];
    }
}