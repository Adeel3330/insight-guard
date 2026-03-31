<?php

namespace Adeel3330\InsightGuard\Dashboard\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use Adeel3330\InsightGuard\Services\{
    SecurityScanner,
    PerformanceAnalyzer,
    DatabaseAnalyzer,
    ModelAnalyzer,
    CodeOptimizer,
    RequestInspector
};

class InsightDashboardController extends Controller
{
    public function index(Request $request)
    {
        $security = (new SecurityScanner())->scanControllers();
        $performance = (new PerformanceAnalyzer())->scanPerformance();
        $database = (new DatabaseAnalyzer())->scanDatabase();
        $modelIssues = (new ModelAnalyzer())->analyzeModel(new \App\Models\User());
        $codeIssues = (new CodeOptimizer())->analyzeRoutes();
        $cacheSuggestions = (new CodeOptimizer())->suggestCaching();
        $requestIssues = (new RequestInspector())->inspect($request);
        // dd($security, $performance, $database, $modelIssues, $codeIssues, $cacheSuggestions, $requestIssues);
        return view('insightguard::dashboard', compact(
            'security', 'performance', 'database', 
            'modelIssues', 'codeIssues', 'cacheSuggestions', 'requestIssues'
        ));
    }

    public function exportPdf(Request $request)
    {
        $security = (new SecurityScanner())->scanControllers();
        $performance = (new PerformanceAnalyzer())->scanPerformance();
        $database = (new DatabaseAnalyzer())->scanDatabase();
        $modelIssues = (new ModelAnalyzer())->analyzeModel(new \App\Models\User());
        $codeIssues = (new CodeOptimizer())->analyzeRoutes();
        $cacheSuggestions = (new CodeOptimizer())->suggestCaching();
        $requestIssues = (new RequestInspector())->inspect($request);

        $pdf = Pdf::loadView('insightguard::dashboard-pdf', compact(
            'security', 'performance', 'database', 
            'modelIssues', 'codeIssues', 'cacheSuggestions', 'requestIssues'
        ));

        return $pdf->download('insightguard_report.pdf');
    }

    public function exportJson(Request $request)
    {
        $security = (new SecurityScanner())->scanControllers();
        $performance = (new PerformanceAnalyzer())->scanPerformance();
        $database = (new DatabaseAnalyzer())->scanDatabase();
        $modelIssues = (new ModelAnalyzer())->analyzeModel(new \App\Models\User());
        $codeIssues = (new CodeOptimizer())->analyzeRoutes();
        $cacheSuggestions = (new CodeOptimizer())->suggestCaching();
        $requestIssues = (new RequestInspector())->inspect($request);

        return response()->json(compact(
            'security', 'performance', 'database', 
            'modelIssues', 'codeIssues', 'cacheSuggestions', 'requestIssues'
        ));
    }
}