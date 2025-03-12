<?php

namespace App\Http\Controllers;

use App\Models\Educaton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ProfileuserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {

        //return view('dashboards.admins.index');
        $users = User::get();
        $user = auth()->user();
        //$user->givePermissionTo('readpaper');
        //return view('home');
        return view('dashboards.users.index', compact('users'));
    }

    function profile()
    {
        return view('dashboards.users.profile');
    }
    function settings()
    {
        return view('dashboards.users.settings');
    }
    

    function updateInfo(Request $request)
{
    $validator = Validator::make($request->all(), [
        'fname_en' => 'required',
        'lname_en' => 'required',
        'fname_th' => 'required',
        'lname_th' => 'required',
        'email' => 'required|email|unique:users,email,' . Auth::user()->id,
    ]);

    if (!$validator->passes()) {
        return response()->json([
            'status' => 0, 
            'error' => $validator->errors()->toArray()
        ]);
    } else {
        $id = Auth::user()->id;
        $title_name_th = '';

        if ($request->title_name_en == "Mr.") {
            $title_name_th = 'นาย';
        } elseif ($request->title_name_en == "Miss") {
            $title_name_th = 'นางสาว';
        } elseif ($request->title_name_en == "Mrs.") {
            $title_name_th = 'นาง';
        }

        // กำหนดค่าตำแหน่ง (Position)
        $pos_eng = '';
        $pos_thai = '';
        $doctoral = null;

        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('student')) {
            $positions = [
                "Professor" => ['Prof.', 'ศ.'],
                "Associate Professor" => ['Assoc. Prof.', 'รศ.'],
                "Assistant Professor" => ['Asst. Prof.', 'ผศ.'],
                "Lecturer" => ['Lecturer', 'อ.']
            ];

            if (isset($positions[$request->academic_ranks_en])) {
                [$pos_eng, $pos_thai] = $positions[$request->academic_ranks_en];

                if (!$request->has('pos')) {
                    if ($pos_eng == "Lecturer") {
                        $pos_eng = $pos_eng;
                        $pos_thai .= 'ดร.';
                        $doctoral = 'Ph.D.';
                    } else {
                        $pos_eng .= ' Dr.';
                        $pos_thai .= 'ดร.';
                        $doctoral = 'Ph.D.';
                    }
                }
            }
        }

        $query = User::find($id)->update([
            'fname_en' => $request->fname_en,
            'lname_en' => $request->lname_en,
            'fname_th' => $request->fname_th,
            'lname_th' => $request->lname_th,
            'email' => $request->email,
            'academic_ranks_en' => $request->academic_ranks_en,
            'academic_ranks_th' => $request->academic_ranks_th,
            'position_en' => $pos_eng,
            'position_th' => $pos_thai,
            'title_name_en' => $request->title_name_en,
            'title_name_th' => $title_name_th,
            'doctoral_degree' => $doctoral,
        ]);

        if (!$query) {
            return response()->json(['status' => 0, 'msg' => __('message.update_failed')]);
        } else {
            return response()->json(['status' => 1, 'msg' => __('message.update_success')]);
        }
    }
}


function updatePicture(Request $request)
{
    $path = 'images/imag_user/';
    $file = $request->file('admin_image');
    $new_name = 'UIMG_' . date('Ymd') . uniqid() . '.jpg';

    // Upload รูปภาพ
    $upload = $file->move(public_path($path), $new_name);

    if (!$upload) {
        return response()->json(['status' => 0, 'msg' => __('message.upload_failed')]);
    } else {
        // ลบรูปเก่า
        $oldPicture = User::find(Auth::user()->id)->getAttributes()['picture'];
        if ($oldPicture != '' && \File::exists(public_path($path . $oldPicture))) {
            \File::delete(public_path($path . $oldPicture));
        }

        // อัปเดตฐานข้อมูล
        $update = User::find(Auth::user()->id)->update(['picture' => $new_name]);

        if (!$update) {
            return response()->json(['status' => 0, 'msg' => __('message.db_update_failed')]);
        } else {
            return response()->json(['status' => 1, 'msg' => __('message.profile_picture_updated')]);
        }
    }
}



function changePassword(Request $request)
{
    // Validate ฟอร์ม
    $validator = Validator::make($request->all(), [
        'oldpassword' => [
            'required', function ($attribute, $value, $fail) {
                if (!\Hash::check($value, Auth::user()->password)) {
                    return $fail(__('message.old_password_incorrect'));
                }
            },
            'min:8', 'max:30'
        ],
        'newpassword' => 'required|min:8|max:30',
        'cnewpassword' => 'required|same:newpassword'
    ], [
        'oldpassword.required' => __('message.old_password_required'),
        'oldpassword.min' => __('message.old_password_min'),
        'oldpassword.max' => __('message.old_password_max'),
        'newpassword.required' => __('message.new_password_required'),
        'newpassword.min' => __('message.new_password_min'),
        'newpassword.max' => __('message.new_password_max'),
        'cnewpassword.required' => __('message.cnewpassword_required'),
        'cnewpassword.same' => __('message.cnewpassword_same')
    ]);

    if (!$validator->passes()) {
        return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
    } else {
        $update = User::find(Auth::user()->id)->update(['password' => \Hash::make($request->newpassword)]);

        if (!$update) {
            return response()->json(['status' => 0, 'msg' => __('message.password_update_failed')]);
        } else {
            return response()->json(['status' => 1, 'msg' => __('message.password_updated')]);
        }
    }
}

}
