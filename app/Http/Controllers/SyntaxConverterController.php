<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SyntaxConversionHistory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyntaxConverterController extends Controller
{
    public function index()
    {
        // Use direct query to avoid the relationship error
        $conversions = SyntaxConversionHistory::where('user_id', Auth::id())
                      ->latest()
                      ->get();
                      
        return view('syntax_converter.user', compact('conversions'));
    }

    public function convert(Request $request)
    {
        // Set batas waktu eksekusi menjadi 120 detik
        set_time_limit(120);

        $request->validate([
            'java_code' => 'required|string',
            'title' => 'nullable|string|max:255',
            'python_code' => 'nullable|string',
            'explanation' => 'nullable|string',
            'tips' => 'nullable|string',
            'level_cs' => 'nullable|string|in:beginner,expert',
            'save_mode' => 'nullable|string' // Added to determine if we're saving or converting
        ]);

        $pythonCode = $request->python_code;
        $explanation = $request->explanation ?? '';
        $tips = $request->tips ?? '';
        $levelCs = $request->level_cs ?? 'beginner';
        $saveMode = $request->save_mode ?? 'convert';
        $executionTime = 0; // Initialize execution time variable

        // If python_code is not provided and we're not in save mode, call the conversion API
        if (!$pythonCode && $saveMode !== 'save') {
            try {
                // Log the attempt to connect to the API
                Log::info('Attempting to connect to conversion API', [
                    'java_code_length' => strlen($request->java_code),
                    'level_cs' => $levelCs
                ]);
                
                // Start measuring execution time
                $startTime = microtime(true);
                
                // Call the Python conversion API with a very high timeout (0 means unlimited)
                $response = Http::timeout(0)->post('http://167.71.212.60:5011/convert_serve', [
                    'java_code' => $request->java_code,
                    'level_cs' => $levelCs
                ]);
                
                // Calculate execution time
                $executionTime = round((microtime(true) - $startTime), 2);
                Log::info('API call completed', ['execution_time' => $executionTime]);
                
                if ($response->successful()) {
                    $pythonCode = $response->json()['python_code'] ?? '';
                    $explanation = $response->json()['explanation'] ?? '';
                    $tips = $response->json()['tips'] ?? '';
                    Log::info('API call successful');
                } else {
                    // Fallback if API call fails
                    $errorMessage = 'API call failed - Status: ' . $response->status();
                    Log::error($errorMessage, ['response' => $response->body()]);
                    $pythonCode = '# ' . $errorMessage;
                    $explanation = 'Explanation not available due to API error. Please make sure the conversion server is running correctly.';
                }
            } catch (\Exception $e) {
                // Log the exception
                Log::error('API connection error', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                // Provide more specific error messages based on exception type
                if (strpos($e->getMessage(), 'Connection refused') !== false) {
                    $pythonCode = '# Server connection error: The conversion server is not running or not accessible.';
                    $explanation = 'The conversion server is currently unavailable. Please contact the administrator.';
                } else if (strpos($e->getMessage(), 'timed out') !== false) {
                    $pythonCode = '# Connection timeout: The conversion server took too long to respond.';
                    $explanation = 'The conversion process timed out. This might happen with very complex code. Please try with a smaller code snippet.';
                } else {
                    $pythonCode = '# Connection error: ' . $e->getMessage();
                    $explanation = 'There was a problem connecting to the conversion server. Please try again later.';
                }
            }
        }

        // Only save to database if we're in save mode
        $conversion = null;
        if ($saveMode === 'save') {
            if ($request->has('conversion_id') && !empty($request->conversion_id)) {
                $conversion = SyntaxConversionHistory::find($request->conversion_id);
                if ($conversion) {
                    $conversion->update([
                        'java_code' => $request->java_code,
                        'python_code' => $pythonCode,
                        'explanation' => $explanation,
                        'tips' => $tips ?? '',
                        'level_cs' => $levelCs,
                        'title' => $request->title ?? 'Untitled Conversion'
                    ]);
                } else {
                    $conversion = SyntaxConversionHistory::create([
                        'user_id'    => Auth::id(),
                        'java_code'  => $request->java_code,
                        'python_code'=> $pythonCode,
                        'explanation'=> $explanation,
                        'tips'       => $tips ?? '',
                        'level_cs'   => $levelCs,
                        'title'      => $request->title ?? 'Untitled Conversion'
                    ]);
                }
            } else {
                $conversion = SyntaxConversionHistory::create([
                    'user_id'    => Auth::id(),
                    'java_code'  => $request->java_code,
                    'python_code'=> $pythonCode,
                    'explanation'=> $explanation,
                    'tips'       => $tips ?? '',
                    'level_cs'   => $levelCs,
                    'title'      => $request->title ?? 'Untitled Conversion'
                ]);
            }
        }

        return response()->json([
            'python_code' => $pythonCode,
            'explanation' => $explanation,
            'tips' => $tips,
            'conversion_id' => $conversion ? $conversion->id : null,
            'execution_time' => $executionTime // Return execution time in the response
        ]);
    }

    public function history()
    {
        // Use direct query to avoid the relationship error
        $conversions = SyntaxConversionHistory::where('user_id', Auth::id())
                      ->latest()
                      ->get();
                      
        return view('syntax_converter.history', compact('conversions'));
    }

    public function show($id)
    {
        $conversion = SyntaxConversionHistory::findOrFail($id);
        
        // Check if the conversion belongs to the authenticated user
        if ($conversion->user_id !== Auth::id() && Auth::user()->role_id != 1) {
            abort(403);
        }
        
        return response()->json($conversion);
    }

    public function delete($id)
    {
        $conversion = SyntaxConversionHistory::findOrFail($id);
        
        // Check if the conversion belongs to the authenticated user
        if ($conversion->user_id !== Auth::id() && Auth::user()->role_id != 1) {
            abort(403);
        }
        
        $conversion->delete();
        
        return redirect()->back()->with('success', 'Conversion deleted successfully');
    }

    public function feedback(Request $request)
    {
        try {
            $surveyType = $request->input('survey_type', 'feedback');
            $waktu = date('Y-m-d H:i:s'); // Simpan waktu saat feedback dikirim
            
            // Create or get a unique request ID to prevent duplicate submissions
            $requestId = md5($request->email . '_' . $waktu);
            
            // Validate required fields for both types of surveys
            $request->validate([
                'email'       => 'required|email',
                'name'        => 'required|string|max:255',
                'java_code'   => 'required|string',
                'python_code' => 'required|string',
                'explanation' => 'nullable|string',
                'tips'        => 'nullable|string',
                'feedback'    => 'required|in:ya,tidak',
                'comment'     => 'nullable|string',
                'level_cs'    => 'required|string|in:beginner,expert',
            ]);
            
            // Create data row for CSV - same structure for both types
            $row = [
                $request->email,
                $request->name,
                $request->java_code,
                $request->python_code,
                $request->explanation,
                $request->tips,
                $request->feedback,
                $request->comment ?? '',
                $waktu,
                $requestId // Add unique request ID to help identify duplicates
            ];
            
            // Store CSV files in the storage directory with proper paths
            $storageDir = storage_path('app/feedback');
            
            // Create directory if it doesn't exist
            if (!file_exists($storageDir)) {
                mkdir($storageDir, 0755, true);
            }
            
            // Choose the appropriate CSV file based on survey type with proper path
            if ($surveyType === 'feedback') {
                // For beginner users (learning)
                $csvFile = $storageDir . '/feedback.csv';
            } else {
                // For expert users (ease of conversion)
                $csvFile = $storageDir . '/kemudahan.csv';
            }
            
            // Log attempt to save feedback
            Log::info('Attempting to save feedback', [
                'survey_type' => $surveyType,
                'csv_file' => $csvFile,
                'storage_dir_exists' => file_exists($storageDir),
                'storage_dir_writable' => is_writable($storageDir)
            ]);
    
            // Check if file exists and has entries
            $isDuplicate = false;
            if (file_exists($csvFile)) {
                try {
                    // Check last few entries to detect duplicates (prevent double submission)
                    $handle = fopen($csvFile, 'r');
                    if ($handle !== false) {
                        // Get the last few lines to check for duplicates
                        $entries = [];
                        while (($data = fgetcsv($handle)) !== false) {
                            $entries[] = $data;
                        }
                        fclose($handle);
                        
                        // Check last 10 entries for a matching email+timestamp (within last 10 seconds)
                        $lastEntries = array_slice($entries, -10);
                        foreach ($lastEntries as $entry) {
                            $entryEmail = $entry[0] ?? '';
                            $entryTime = $entry[count($entry)-2] ?? ''; // Time is second-to-last field
                            
                            // If same email and within 10 seconds, consider it a duplicate
                            if ($entryEmail === $request->email && 
                                (strtotime($waktu) - strtotime($entryTime) < 10)) {
                                $isDuplicate = true;
                                break;
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Error reading CSV file', [
                        'error' => $e->getMessage(),
                        'file' => $csvFile
                    ]);
                    // Continue execution, we'll try to create or append to the file
                }
            }
            
            // Only save if not duplicate
            if (!$isDuplicate) {
                try {
                    // Create file with headers if it doesn't exist
                    if (!file_exists($csvFile)) {
                        $headers = ['Email', 'Nama', 'Java Code', 'Python Code', 'Explanation', 'Tips', 'Feedback', 'Komentar', 'Waktu', 'Request ID'];
                        
                        $handle = fopen($csvFile, 'w');
                        if ($handle === false) {
                            throw new \Exception("Could not open file for writing: $csvFile");
                        }
                        fputcsv($handle, $headers);
                        fclose($handle);
                    }
        
                    // Append data to the CSV file
                    $handle = fopen($csvFile, 'a');
                    if ($handle === false) {
                        throw new \Exception("Could not open file for appending: $csvFile");
                    }
                    fputcsv($handle, $row);
                    fclose($handle);
                    
                    Log::info('Feedback saved successfully', [
                        'survey_type' => $surveyType,
                        'file' => $csvFile
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error writing to CSV file', [
                        'error' => $e->getMessage(),
                        'file' => $csvFile
                    ]);
                    throw $e; // Re-throw to be caught by outer catch block
                }
            }
    
            // Always return JSON response
            return response()->json(['message' => 'Feedback saved successfully']);
            
        } catch (\Exception $e) {
            // Log the error and return a proper JSON response
            Log::error('Feedback submission error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => 'An error occurred while saving feedback: ' . $e->getMessage()], 500);
        }
    }

    public function featureGuide()
    {
        return view('syntax_converter.feature_guide');
    }
}
