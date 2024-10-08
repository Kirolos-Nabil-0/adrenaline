<?php


namespace App\Http\Controllers;

use App\Models\SettingWeb;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;

class SettingWebController extends Controller
{
    public function privecy(Request $request)
    {
        $settings = SettingWeb::first();
        // return $settings;
        return view('dashboard.term.privecy', compact('settings'));
    }
    public function terms(Request $request)
    {
        $settings = SettingWeb::first();
        // return $settings;
        return view('dashboard.term.term', compact('settings'));
    }

    public function order_success()
    {
        return view('dashboard.order.success');
    }

    public function order_failed()
    {
        return view('dashboard.order.failed');
    }

    public function index()
    {
        $settings = SettingWeb::first();
        // return $settings;
        return view('dashboard.setting.setting_web', compact('settings'));
    }


    public function update(Request $request)
    {
        $rules = [
            'about_us_ar' => 'nullable|string',
            'about_us_en' => 'nullable|string',
            'terms_ar' => 'nullable|string',
            'terms_en' => 'nullable|string',
            'privacy_ar' => 'nullable|string',
            'privacy_en' => 'nullable|string',
            'return_policy_ar' => 'nullable|string',
            'return_policy_en' => 'nullable|string',
            'store_policy_ar' => 'nullable|string',
            'store_policy_en' => 'nullable|string',
            'seller_policy_ar' => 'nullable|string',
            'seller_policy_en' => 'nullable|string',
            'color_primery' => 'nullable|string',
            'color_second_primery' => 'nullable|string',
            'licance_web' => 'nullable|string',
            'banner' => 'nullable|string',
            'video_link' => 'nullable|string',
            'is_debug' => 'nullable|boolean',
            'is_debug_2' => 'nullable|boolean',
            'is_debug_3' => 'nullable|boolean',
            'is_debug_4' => 'nullable|boolean',
            'is_debug_5' => 'nullable|boolean',
            'is_debug_6' => 'nullable|boolean',
            'is_debug_7' => 'nullable|boolean',
            'dooler_price' => 'nullable|numeric',
            'phone_number' => 'nullable|string',
            'telegram' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        $settingWeb = SettingWeb::first();

        if ($settingWeb) {
            $settingWeb->update($validatedData);
            session()->flash('edit', 'تم تعديل الاعدادت بنجاح');
            return redirect()->route('setting_web')->with('edit', 'تم تعديل الاعدادت بنجاح');
        } else {
            session()->flash('delete', 'لم يتم تعديل الاعدادت');
            return redirect()->route('setting_web')->with('Erorr', 'لم يتم تعديل الاعدادت ');
        }
    }
}
