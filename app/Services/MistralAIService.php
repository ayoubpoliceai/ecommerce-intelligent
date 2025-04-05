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
        $this->apiUrl = 'https://api-inference.huggingface.co/models/tiiuae/falcon-7b-instruct';
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

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => false // 🧨 POUR TEST LOCAL UNIQUEMENT
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
                throw new \Exception("Erreur API: " . $response->body());
            }

            $generated = $response->json();
            $text = $generated[0]['generated_text'] ?? null;

            if (!$text) {
                throw new \Exception("Pas de texte généré");
            }

            preg_match('/\{.*\}/s', $text, $matches);
            if (empty($matches)) {
                throw new \Exception("JSON introuvable dans la réponse");
            }

            $jsonData = json_decode($matches[0], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Erreur JSON : " . json_last_error_msg());
            }

            return $jsonData;

        } catch (\Exception $e) {
            Log::error("Erreur IA - Falcon : " . $e->getMessage());
            throw $e;
        }
    }
}
