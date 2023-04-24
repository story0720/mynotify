<?php

namespace App\Http\Controllers;

use App\Models\Notify;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class NotifyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nowday = Carbon::now()->format('Y-m-d\TH:i');


        $today = Carbon::today();
        $dates = [];

        for ($i = 0; $i < 60; $i++) {
            $date = $today->copy()->subDays($i)->toDateString();
            $dayOfWeek = $today->copy()->subDays($i)->dayOfWeek;
            $dayOfWeekString = ['週日', '週一', '週二', '週三', '週四', '週五', '週六'][$dayOfWeek];
            $dates[$date] = ['date' => $date, 'dayOfWeek' => $dayOfWeekString, 'items' => []];
        }

        $notifys = Notify::all();

        foreach ($notifys as $value) {
            foreach ($dates as $key => $date) {
                $startDate = Carbon::parse($date['date'])->startOfDay();
                $endDate = Carbon::parse($date['date'])->endOfDay();
                if ($value->starttime->between($startDate, $endDate) && $value->endtime->between($startDate, $endDate)) {
                    $dates[$key]['items'][] = $value;
                }
            }
        }
        // dd($dates);
        return view('notify.index', compact('today', 'dates', 'nowday'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $requestData = $request->all();
            $requestData['status'] = $request->has('status') ? 1 : 0;
            $data = Notify::create($requestData);
            if (isset($data->id) && $data->id > 0) {
                return response()->json([
                    'status' => 'success',
                    'message' => '資料儲存成功！',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => '資料儲存失敗！',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => '資料儲存失敗！',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Notify $notify)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notify $notify)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notify $notify)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notify $notify)
    {
        //
    }
}
