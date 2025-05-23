<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HistoryApiService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.llm_api.url', 'http://localhost:8001/api/v1');
    }

    /**
     * Get history list with pagination
     */
    public function getHistoryList($limit = 20, $offset = 0)
    {
        try {
            $response = Http::get("{$this->baseUrl}/history", [
                'limit' => $limit,
                'offset' => $offset
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Error fetching history list', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return ['success' => false, 'data' => []];
        } catch (\Exception $e) {
            Log::error('Exception fetching history list', [
                'message' => $e->getMessage()
            ]);
            return ['success' => false, 'data' => []];
        }
    }

    /**
     * Get history detail by ID
     */
    public function getHistoryDetail($historyId)
    {
        try {
            $response = Http::get("{$this->baseUrl}/history/{$historyId}");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Error fetching history detail', [
                'status' => $response->status(),
                'response' => $response->body(),
                'historyId' => $historyId
            ]);

            return ['success' => false, 'data' => null];
        } catch (\Exception $e) {
            Log::error('Exception fetching history detail', [
                'message' => $e->getMessage()
            ]);
            return ['success' => false, 'data' => null];
        }
    }

    /**
     * Get history for a specific content
     */
    public function getContentHistory($contentId, $limit = 10)
    {
        try {
            $response = Http::get("{$this->baseUrl}/content/{$contentId}/history", [
                'limit' => $limit
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Error fetching content history', [
                'status' => $response->status(),
                'response' => $response->body(),
                'contentId' => $contentId
            ]);

            return ['success' => false, 'data' => []];
        } catch (\Exception $e) {
            Log::error('Exception fetching content history', [
                'message' => $e->getMessage()
            ]);
            return ['success' => false, 'data' => []];
        }
    }

    /**
     * Search history by topic
     */
    public function searchHistory($query, $limit = 20, $offset = 0)
    {
        try {
            $response = Http::get("{$this->baseUrl}/history/search", [
                'q' => $query,
                'limit' => $limit,
                'offset' => $offset
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Error searching history', [
                'status' => $response->status(),
                'response' => $response->body(),
                'query' => $query
            ]);

            return ['success' => false, 'data' => []];
        } catch (\Exception $e) {
            Log::error('Exception searching history', [
                'message' => $e->getMessage()
            ]);
            return ['success' => false, 'data' => []];
        }
    }
}
