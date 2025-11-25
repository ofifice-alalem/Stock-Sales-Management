<?php

declare(strict_types=1);

namespace App\Services\WhatsApp;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class WhatsAppService
{
    private const API_URL = 'https://graph.facebook.com/v17.0';

    public function __construct(
        private readonly string $phoneNumberId,
        private readonly string $accessToken
    ) {}

    public function sendDocument(string $recipientPhone, string $documentPath, string $caption): bool
    {
        try {
            $response = Http::withToken($this->accessToken)
                ->attach('file', file_get_contents($documentPath), basename($documentPath))
                ->post(self::API_URL . "/{$this->phoneNumberId}/media");

            if (!$response->successful()) {
                Log::error('WhatsApp media upload failed', ['response' => $response->json()]);
                return false;
            }

            $mediaId = $response->json('id');

            $messageResponse = Http::withToken($this->accessToken)
                ->post(self::API_URL . "/{$this->phoneNumberId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'to' => $recipientPhone,
                    'type' => 'document',
                    'document' => [
                        'id' => $mediaId,
                        'caption' => $caption,
                        'filename' => basename($documentPath),
                    ],
                ]);

            return $messageResponse->successful();
        } catch (\Exception $e) {
            Log::error('WhatsApp send failed', ['error' => $e->getMessage()]);
            return false;
        }
    }
}
