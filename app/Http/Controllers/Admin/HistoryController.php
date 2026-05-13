<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Laracasts\Flash\Flash;
use Response;

class HistoryController extends AppBaseController
{
    /**
     * Display a listing of the generation history.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            $search = $request->get('q', '');
            $page = $request->get('page', 1);
            $limit = 20;
            $offset = ($page - 1) * $limit;

            Log::info('📜 Fetching generation history from Django service', [
                'search' => $search,
                'page' => $page,
                'limit' => $limit,
                'offset' => $offset
            ]);

            // Fetch from Django service only (migration from FastAPI)
            $response = $this->fetchFromDjangoService($search, $limit, $offset);
            $histories = $response['data'] ?? [];
            $total = $response['total'] ?? 0;

            // Convert to paginated format for Laravel
            $paginatedHistories = $this->createPaginatedCollection($histories, $total, $limit);

            return view('admin.history.index')
                ->with('histories', $paginatedHistories)
                ->with('search', $search);
        } catch (\Exception $e) {
            Log::error('❌ Error loading history page', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            Flash::error('Error loading generation history: ' . $e->getMessage());

            // Return empty collection for graceful degradation
            $emptyCollection = collect([])->paginate(20);

            return view('admin.history.index')
                ->with('histories', $emptyCollection)
                ->with('search', $request->get('q', ''));
        }
    }

    /**
     * Display the specified history detail.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            Log::info('📖 Fetching history detail from Django service', ['id' => $id]);

            // Fetch from Django service only (migration from FastAPI)
            $history = $this->fetchHistoryDetailFromDjango($id);

            if (empty($history)) {
                Flash::error('Generation history not found');
                return redirect(route('admin.history.index'));
            }

            return view('admin.history.show')->with('history', $history);
        } catch (\Exception $e) {
            Log::error('❌ Error loading history detail', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            Flash::error('Error loading history detail: ' . $e->getMessage());
            return redirect(route('admin.history.index'));
        }
    }

    /**
     * Display history for a specific content.
     *
     * @param int $contentId
     * @return Response
     */
    public function contentHistory($contentId)
    {
        try {
            $limit = request()->get('limit', 10);

            Log::info('📋 Fetching content history from Django service', [
                'content_id' => $contentId,
                'limit' => $limit
            ]);

            // Fetch from Django service
            $histories = $this->fetchContentHistoryFromDjango($contentId, $limit);
            
            // Fetch content model to fix crash in view
            $content = \App\Models\Content::findOrFail($contentId);

            return view('admin.history.content')
                ->with('histories', $histories)
                ->with('content', $content)
                ->with('contentId', $contentId);
        } catch (\Exception $e) {
            Log::error('❌ Error loading content history', [
                'content_id' => $contentId,
                'error' => $e->getMessage()
            ]);

            Flash::error('Error loading content history: ' . $e->getMessage());
            return redirect(route('admin.history.index'));
        }
    }

    /**
     * Fetch history from Django service
     */
    private function fetchFromDjangoService($search = '', $limit = 20, $offset = 0)
    {
        try {
            $compilerUrl = config('app.compiler_api_url', 'http://127.0.0.1:8000/api');
            $url = rtrim($compilerUrl, '/') . '/history/';
            $params = [
                'limit' => $limit,
                'offset' => $offset
            ];

            if (!empty($search)) {
                $url = rtrim($compilerUrl, '/') . '/history/search/';
                $params['q'] = $search;
            }

            Log::info('🌐 Calling Django service', [
                'url' => $url,
                'params' => $params
            ]);

            $response = Http::timeout(30)->get($url, $params);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['success']) && $data['success']) {
                    Log::info('✅ Successfully fetched from Django service', [
                        'count' => count($data['data'] ?? []),
                        'total' => $data['total'] ?? 0
                    ]);
                    return $data;
                }
            }

            Log::warning('⚠️ Django service call failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Django service not available', [
                'error' => $e->getMessage()
            ]);
        }

        return ['data' => [], 'total' => 0];
    }

    /**
     * Fetch history detail from Django service
     */
    private function fetchHistoryDetailFromDjango($id)
    {
        try {
            $compilerUrl = config('app.compiler_api_url', 'http://127.0.0.1:8000/api');
            $url = rtrim($compilerUrl, '/') . "/history/{$id}/";

            Log::info('🌐 Fetching detail from Django', ['url' => $url]);

            $response = Http::timeout(30)->get($url);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['success']) && $data['success'] && isset($data['data'])) {
                    Log::info('✅ Successfully fetched history detail from Django');
                    return $data['data'];
                }
            }

            Log::warning('⚠️ Django detail fetch failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Django detail fetch failed', [
                'error' => $e->getMessage()
            ]);
        }

        return null;
    }

    /**
     * Fetch content history from Django service
     */
    private function fetchContentHistoryFromDjango($contentId, $limit = 10)
    {
        try {
            $compilerUrl = config('app.compiler_api_url', 'http://127.0.0.1:8000/api');
            $url = rtrim($compilerUrl, '/') . "/content/{$contentId}/history/";
            $params = ['limit' => $limit];

            Log::info('🌐 Fetching content history from Django', [
                'url' => $url,
                'params' => $params
            ]);

            $response = Http::timeout(30)->get($url, $params);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['success']) && $data['success'] && isset($data['data'])) {
                    Log::info('✅ Successfully fetched content history from Django');
                    return $data['data'];
                }
            }

            Log::warning('⚠️ Django content history fetch failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Django content history fetch failed', [
                'error' => $e->getMessage()
            ]);
        }

        return [];
    }

    /**
     * Create paginated collection from array data
     */
    private function createPaginatedCollection($data, $total, $perPage = 20)
    {
        $currentPage = request()->get('page', 1);

        // Since the Django service already returned only the items for the current page,
        // we do NOT slice the array again. We pass the data as is.
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $data,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(), // Preserve query parameters like search 'q'
                'pageName' => 'page',
            ]
        );

        return $paginator;
    }
}
