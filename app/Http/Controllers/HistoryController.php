<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Services\HistoryApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    protected $historyApiService;

    public function __construct(HistoryApiService $historyApiService)
    {
        $this->historyApiService = $historyApiService;
    }

    /**
     * Display a listing of the history logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $search = $request->input('q');

        if ($search) {
            $response = $this->historyApiService->searchHistory($search, $limit, $offset);
        } else {
            $response = $this->historyApiService->getHistoryList($limit, $offset);
        }

        $histories = $response['success'] ? $response['data'] : [];

        // Create a custom paginator
        $total = count($histories) + ($page > 1 ? ($page - 1) * $limit : 0);
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $histories,
            $total,
            $limit,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.history.index', [
            'histories' => $paginator,
            'search' => $search
        ]);
    }

    /**
     * Display the specified history log.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->historyApiService->getHistoryDetail($id);

        if (!$response['success'] || !$response['data']) {
            return redirect()->route('admin.history.index')
                ->with('error', 'History log not found');
        }

        $history = $response['data'];

        return view('admin.history.show', compact('history'));
    }

    /**
     * Display history logs for a specific content.
     *
     * @param  int  $contentId
     * @return \Illuminate\Http\Response
     */
    public function contentHistory($contentId)
    {
        $content = Content::findOrFail($contentId);

        $response = $this->historyApiService->getContentHistory($contentId);
        $histories = $response['success'] ? $response['data'] : [];

        return view('admin.history.content', compact('histories', 'content'));
    }
}
