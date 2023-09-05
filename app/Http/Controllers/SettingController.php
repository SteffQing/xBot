<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Traits\NotificationTrait;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use NotificationTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validateWithBag('settingsUpdate', [
            'base_pair' => 'required|string',
            'pair_to_trade' => 'required|string',
            'order_size' => 'required|numeric|min:0',
            'trading_type' => 'required|in:spot,margin',
            'variation_percentage_range' => 'required|numeric|min:1|max:100',
            'price_ratio' => 'required|numeric|min:0.01|max:100',
            'operation_interval' => 'required|numeric|min:2',
        ]);

        $data = $request->except('_token');

        $settingsToUpdate = [];

        foreach ($data as $key => $value) {
            $settingsToUpdate[] = [
                'name' => $key,
                'current_value' => $value,
            ];
        }

        Setting::upsert($settingsToUpdate, ['name'], ['current_value']);

        $this->notify(null, null, 'Settings Updated Successfully');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
