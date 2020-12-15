<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Exception;
use Illuminate\Http\Request;
use App\Services\ReportService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{

    protected $reportService;

    public function __construct(ReportService $reportService) {
        $this->reportService = $reportService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Returning the view so we get HTML in JavaScript and don't have to recreate the template there.
        try {
            $reports = $this->reportService->getAll();
            $result = [
                'status' => 200,
                'data' => $reports,
                'html' => view('components.report.reportList', ['reports' => $reports])->render()
            ];
        } catch(Exception $e) {
            $result = [
                'status' => 500,
                'message' => $e->getMessage()
            ];
        }
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $data = $request->only([
                'title',
                'icon'
            ]);

            //Store report icon in public folder and set filename as icon in the report data

            $report = $this->reportService->save($data);
            $result = [
                'status' => 200,
                'data' => $report,
                'html' => view('components.report.reportItem', ['report' => $report])->render()
            ];

        }catch(Exception $e) {
            $result = [
                'status' => 500,
                'message' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only([
            'title'
        ]);

        try {
            $result = [
                'status' => 200,
                'data' => $this->reportService->update($data, $id)
            ];
        } catch(Exception $e) {
            $result = [
                'status' => 500,
                'message' => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $result = [
                'status' => 200,
                'data' => $this->reportService->delete($id)
            ];
        } catch(Exception $e) {
            $result = [
                'status' => 500,
                'message' => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }
}
