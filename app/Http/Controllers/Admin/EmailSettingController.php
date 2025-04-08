<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmailSetting\CreateRequest;
use App\Models\EmailSetting;
use Exception;
use Illuminate\Http\Request;

class EmailSettingController extends Controller
{
    public function index() {
        $settings = EmailSetting::first();
        return view('admin.email-setting.index',compact('settings'));
    }

    public function store(CreateRequest $request) {
        try {
            $checkEmailSettingsExists = EmailSetting::first();
            if(!is_null($checkEmailSettingsExists)):
                $checkEmailSettingsExists->update([
                    'smtp_host'=>$request->input('smtp_host'),
                    'smtp_port'=>$request->input('smtp_port'),
                    'encryption_type'=>$request->input('encryption_type'),
                    'smtp_username'=>$request->input('smtp_username'),
                    'smtp_password'=>$request->input('smtp_password'),
                    'from_email_address'=>$request->input('from_email_address'),
                    'from_name'=>$request->input('from_name')
                ]);
            else:
                EmailSetting::create([
                    'smtp_host'=>$request->input('smtp_host'),
                    'smtp_port'=>$request->input('smtp_port'),
                    'encryption_type'=>$request->input('encryption_type'),
                    'smtp_username'=>$request->input('smtp_username'),
                    'smtp_password'=>$request->input('smtp_password'),
                    'from_email_address'=>$request->input('from_email_address'),
                    'from_name'=>$request->input('from_name')
                ]);
            endif;
            return response()->json([
                'status'=>true,
                'message'=>"Email Setting Update successfully",
                'url'=>route('admin.email.settings.index')
            ],200);
        }catch(Exception $e) {
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage(),
            ],500);
        }

    }

}
