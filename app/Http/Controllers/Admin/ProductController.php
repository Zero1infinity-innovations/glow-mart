<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\Product\CreateRequest;
use App\Models\inventories;

class ProductController extends Controller
{
    public function index(Request $request) {
        if($request->ajax()):
            $product  = Product::latest();
            return DataTables::of($product)
            ->addIndexColumn()
            ->addColumn('action',function($row){
                $status = $row->status==1?"0":"1";
                $class =  $row->status==1?"bx-x":"bx-check";
                $title = $row->status==1?"Mark Inactive":"Mark Active";
                return '<div><a href="javascript:void()" title="'.$title.'" onclick="changeStatus(\''.route('admin.product.change.status').'\','.$row->id.','.$status.')"> <i class="bx '.$class.' fs-4 fw-medium"></i></a></div><div><a href="'.route('admin.product.edit',base64_encode($row->id)).'" title="'.$title.'"><i class="bx bxs-edit-alt text-warning fs-4"></i> </a></div>';
            })
            ->editColumn('image',function($row) {
               if ($row->image):
                      return  '<img src="'.env('IMAGE_URL').'/product-images/'.$row->image.'" alt="'.$row->name.'" width="50">';
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
        return $this->create();
        // return view('admin.product.index');
    }

    public function create() {
        $categories = Category::get(['id','category_name as name']);
        return view('admin.product.create',compact(['categories'=>$categories]));
    }

    public function store(CreateRequest $request) {
        try{
            $fileName = NULL;
            if($request->hasFile('image')):
                $ext = 'webp';
                $convertImage = Image::make($request->file('image'))->encode($ext, 60);
                $fileName = uniqid().'.'.$ext;
                if(env('AWS_BUCKET_ENABLED')):
                    Storage::disk('s3')->put('product-images/'.$fileName,$convertImage);
                else:
                    Storage::disk('public')->put('product-images/'.$fileName, $convertImage);
                endif;
            endif;
            $slug = Str::slug($request->input('name'));
            $product = Product::create([
                'image'=>$fileName,
                'slug'=>$slug,
                'name'=>$request->input('name'),
                'seo_title'=>$request->input('seo_title'),
                'seo_description'=>$request->input('seo_description'),
                'status'=>$request->input('status'),
            ]);
            if(!$product):
                return response()->json([
                    'status'=>false,
                    'message'=>"Product not created,Please try again !"
                ]);
            else:
                return response()->json([
                    'status'=>true,
                    'message'=>"Product created, Please Wait redirecting....",
                    'url'=>route('admin.product.index')
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
            $product = Product::find($request->input('id'))->update([
                'status'=>(string)$request->input('status'),
            ]);
            $msessage  = $request->input('status') =='1' ?"Product has been active":"Product has been inactive";
            if(!$product):
                return response()->json([
                    'status'=>false,
                    'message'=>"Product not a Update,Please try again !"
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
        $product = Product::find(base64_decode($id));
        return view('admin.product.edit',compact('product'));
    }

    public function update(Request $request) {
        try{
            $fileName = $request->input('old_image');
            if($request->hasFile('image')):
                $ext = 'webp';
                $convertImage = Image::make($request->file('image'))->encode($ext, 60);
                $fileName = uniqid().'.'.$ext;
                if(env('AWS_BUCKET_ENABLED')):
                    Storage::disk('s3')->put('product-images/'.$fileName,$convertImage);
                else:
                    Storage::disk('public')->put('product-images/'.$fileName, $convertImage);
                endif;
            endif;
            $slug = Str::slug($request->input('name'));
            $product = Product::find($request->input('id'))->update([
                'image'=>$fileName,
                'slug'=>$slug,
                'name'=>$request->input('name'),
                'seo_title'=>$request->input('seo_title'),
                'seo_description'=>$request->input('seo_description'),
                'status'=>$request->input('status'),
            ]);
            if(!$product):
                return response()->json([
                    'status'=>false,
                    'message'=>"Product not Update,Please try again !"
                ]);
            else:
                return response()->json([
                    'status'=>true,
                    'message'=>"Product Update, Please Wait redirecting....",
                    'url'=>route('admin.product.index')
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
