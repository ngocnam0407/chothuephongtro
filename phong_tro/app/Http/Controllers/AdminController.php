<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Motelroom;
use App\Reports;
class AdminController extends Controller
{
    public function getIndex(){
      $total_users_active = User::where('tinhtrang',1)->get()->count();
      $total_users_deactive = User::where('tinhtrang',0)->get()->count();
      $total_rooms_approve = Motelroom::where('approve',1)->get()->count();
      $total_rooms_unapprove = Motelroom::where('approve',0)->get()->count();
      $reports = Reports::all();
      return view ('admin.index',[
        'total_users_active'=>$total_users_active,
        'total_users_deactive'=>$total_users_deactive,
        'total_rooms_approve'=>$total_rooms_approve,
        'total_rooms_unapprove'=>$total_rooms_unapprove,
        'total_report'=>$reports->count(),
      ]);
    }
    public function getThongke(){
      $total_users_active = User::where('tinhtrang',1)->get()->count();
      $total_users_deactive = User::where('tinhtrang',0)->get()->count();
      $total_rooms_approve = Motelroom::where('approve',1)->get()->count();
      $total_rooms_unapprove = Motelroom::where('approve',0)->get()->count();
      $reports = Reports::all();
      return view ('admin.thongke',[
        'total_users_active'=>$total_users_active,
        'total_users_deactive'=>$total_users_deactive,
        'total_rooms_approve'=>$total_rooms_approve,
        'total_rooms_unapprove'=>$total_rooms_unapprove,
        'total_report'=>$reports->count(),
      ]);
    }

    public function getReport(){
      $reports = Reports::all()->count();
      $motels = Motelroom::all();
      return view ('admin.report',[
        'motels'=>$motels,
        'reports' => $reports
      ]);
    }
    public function logout(){
        Auth::logout();
      return redirect('admin');
    }
    public function getLogin(){
    	return view('admin.login');
    }
    public function postLogin(Request $req){
    	$req->validate([
   			'username' => 'required',
   			'password' => 'required',
   			
   		],[
   			'username.required' => 'Vui l??ng nh???p t??i kho???n',
   			'password.required' => 'Vui l??ng nh???p m???t kh???u'
   			
   		]);
   		if(Auth::attempt(['username'=>$req->username,'password'=>$req->password])){
    		return redirect('admin');

    	}
    	else 
    		return redirect('admin/login')->with('thongbao','????ng nh???p kh??ng th??nh c??ng');
    }
    public function getListUser(){
      $users = User::all();
      return view('admin.users.list',['users'=>$users]);
    }
    /* Motel room */
    public function getListMotel(){
      $motelrooms = Motelroom::all();
      return view('admin.motelroom.list',['motelrooms'=>$motelrooms]);
    }
    public function ApproveMotelroom($id){
      $room = Motelroom::find($id);
      $room->approve = 1;
      $room->save();
      return redirect('admin/motelrooms/list')->with('thongbao','???? ki???m duy???t b??i ????ng: '.$room->title);
    }
    public function UnApproveMotelroom($id){
      $room = Motelroom::find($id);
      $room->approve = 0;
      $room->save();
      return redirect('admin/motelrooms/list')->with('thongbao','???? b??? ki???m duy???t b??i ????ng: '.$room->title);
    }
    public function DelMotelroom($id){
      $room = Motelroom::find($id);
      $room->delete();
      return redirect('admin/motelrooms/list')->with('thongbao','???? x??a b??i ????ng');
    }

    /* user */
    public function getUpdateUser($id){
      $user = User::find($id);
      return view('admin.users.edit',['user'=>$user]);
    }
    public function postUpdateUser(Request $request,$id){
      $this->validate($request,[
          'HoTen' => 'required'
        ],[
          'HoTen.required' => 'Vui l??ng nh???p ?????y ????? H??? T??n'
        ]);
      $user = User::find($id);
      $user->name = $request->HoTen;
      $user->right = $request->Quyen;
      $user->tinhtrang = $request->TinhTrang;

      if($request->password != ''){
        $this->validate($request,[
          'password' => 'min:3|max:32',
          'repassword' => 'same:password',
        ],[
          'password.min' => 'M???t kh???u ph???i l???n h??n 3 v?? nh??? h??n 32 k?? t???',
          'password.max' => 'M???t kh???u ph???i l???n h??n 3 v?? nh??? h??n 32 k?? t???',
          'repassword.same' => 'Nh???p l???i m???t kh???u kh??ng ????ng',
          'repassword.required' => 'Vui l??ng nh???p l???i m???t kh???u',
        ]);
        $user->password = bcrypt($request->password);
      }

      
      $user->save();
      return redirect('admin/users/edit/'.$id)->with('thongbao','Ch???nh s???a th??nh c??ng t??i kho???n '.$request->username.' .');
    }
    public function DeleteUser($id){
      $user = User::find($id);
      $user->delete();
      return redirect('admin/users/list')->with('thongbao','???? x??a ng?????i d??ng kh???i danh s??ch. Nh???ng b??i ????ng c???a ng?????i d??ng n??y c??ng b??? x??a');
    }
}
