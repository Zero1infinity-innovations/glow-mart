<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Banner;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\Banner\CreateRequest;

class BannerController extends Controller
{
    public function index(Request $request) {
        if($request->ajax()):
            $banner  = Banner::latest();
            return DataTables::of($banner)
            ->addIndexColumn()
            ->addColumn('action',function($row){
                $status = $row->status==1?"0":"1";
                $class =  $row->status==1?"bx-x":"bx-check";
                $title = $row->status==1?"Mark Inactive":"Mark Active";
                return '<div><a href="javascript:void()" title="'.$title.'" onclick="changeStatus(\''.route('admin.banner.change.status').'\','.$row->id.','.$status.')"> <i class="bx '.$class.' fs-4 fw-medium"></i></a></div><div><a href="'.route('admin.banner.edit',base64_encode($row->id)).'" title="'.$title.'"><i class="bx bxs-edit-alt text-warning fs-4"></i> </a></div>';
            })
            ->editColumn('image',function($row) {
               if ($row->image):
                      return  '<img src="'.env('IMAGE_URL').'/banner_image/'.$row->image.'" alt="'.$row->banner_type.'" width="50">';
               else:
                    return '<span class="text-muted">No image</span>';
               endif;
            })
            ->editColumn('status',function($row) {
                if ($row->status):
                       return  '<span class="badge bg-success">Active</span>';
                else:
                     return ' <span class="badge bg-danger">Inactive</span>';
                endif;
             })
            ->rawColumns(['action','image','status'])
            ->make(true);
        endif;
        return view('admin.banner.index');
    }

    public function create() {
        return view('admin.banner.create');
    }

    public function store(CreateRequest $request) {
        try{
            $fileName = NULL;
            if($request->hasFile('banner_image')):
                $ext = 'webp';
                $convertImage = Image::make($request->file('banner_image'))->encode($ext, 60);
                $fileName = uniqid().'.'.$ext;
                if(env('AWS_BUCKET_ENABLED')):
                    Storage::disk('s3')->put('banner_image/'.$fileName,$convertImage);
                else:
                    Storage::disk('public')->put('banner_image/'.$fileName, $convertImage);
                endif;
            endif;
            $banner = Banner::create([
                'banner_type'=>$request->input('banner_type'),
                'image'=>$fileName,
                'status'=>$request->input('status'),
            ]);
            if(!$banner):
                return response()->json([
                    'status'=>false,
                    'message'=>"Banner not created,Please try again !"
                ]);
            else:
                return response()->json([
                    'status'=>true,
                    'message'=>"Banner created, Please Wait redirecting....",
                    'url'=>route('admin.banner.index')
                ],200);
            endif;
        }catch(Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage(),
            ],500);
        }
    }

    public function changeStatus(Request $request) {
        try {
            $banner = Banner::find($request->input('id'))->update([
                'status'=>(string)$request->input('status'),
            ]);
            $msessage  = $request->input('status') =='1' ?"Banner has been active":"Banner has been inactive";
            if(!$banner):
                return response()->json([
                    'status'=>false,
                    'message'=>"Banner not a Update,Please try again !"
                ]);
            else:
                return response()->json([
                    'status'=>true,
                    'message'=>$msessage
                    // 'url'=>route('admin.country.index')
                ],200);
            endif;
        }catch (Exception $e) {
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage(),
            ],500);
        }
    }

    public function edit($id) {
        $banner = Banner::find(base64_decode($id));
        return view('admin.banner.edit',compact('banner'));
    }

    public  function update(Request $request) {
        try{
            $fileName = $request->input('old_image');
            if($request->hasFile('banner_image')):
                $ext = 'webp';
                $convertImage = Image::make($request->file('banner_image'))->encode($ext, 60);
                $fileName = uniqid().'.'.$ext;
                if(env('AWS_BUCKET_ENABLED')):
                    Storage::disk('s3')->put('banner_image/'.$fileName,$convertImage);
                else:
                    Storage::disk('public')->put('banner_image/'.$fileName, $convertImage);
                endif;
            endif;
            $banner = Banner::find($request->input('id'))->update([
                'banner_type'=>$request->input('banner_type'),
                'image'=>$fileName,
                'status'=>$request->input('status'),
            ]);
            if(!$banner):
                return response()->json([
                    'status'=>false,
                    'message'=>"Banner not Update,Please try again !"
                ]);
            else:
                return response()->json([
                    'status'=>true,
                    'message'=>"Banner Update, Please Wait redirecting....",
                    'url'=>route('admin.banner.index')
                ],200);
            endif;
        }catch(Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage(),
            ],500);
        }
    }

}
