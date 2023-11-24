<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class AuthController extends Controller
{
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function proses(Request $request){
        $credential = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        
        if (Auth::guard('web')->attempt($credential)) {
            $user = Auth::user(); // Mengambil objek pengguna yang telah login
            
            if ($user->status == 2) {
                // Pengguna memiliki status 2, mereka diizinkan untuk login
                return redirect()->intended('/dashboard');
            } else {
                // Pengguna tidak memiliki status 2, maka Anda bisa menolak login
                Auth::logout(); // Keluarkan pengguna yang mencoba login
                Session::flash('status', 'failed');
                Session::flash('pesan', 'Gagal Login!! Akun anda belum aktif..tunggu beberapa saat');
                return redirect('/');
            }
        } else {
            Session::flash('status', 'failed');
            Session::flash('pesan', 'Gagal Login!! Username atau password salah');
            return redirect('/');
        }
    }
    
    public function register(){
        return view('login.register');
    }

    public function registerProses(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required',
            'password_confirm' => 'required|same:password'
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'username.required' => 'Username harus diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password harus diisi.',
            'password_confirm.required' => 'Konfirmasi password harus diisi.',
            'password_confirm.same' => 'Konfirmasi password tidak cocok dengan password yang dimasukkan.'
        ]);
        
        
        $request['name'] = $request->name;
        $request['email'] = $request->email;
        $request['username'] = $request->username;
        $request['password'] = Hash::make($request->password);
        $request['role_id'] = '2';
        $request['status'] = '1';
        
        $register = User::create($request->all());
        if($register){
            Session::flash('status', 'success');
            Session::flash('pesan', 'Akun anda berhasil didaftar..silahkan tunggu beberapa saat sampai akun anda aktif !!');
        }else{
            Session::flash('status', 'error');
            Session::flash('pesan', 'Akun anda Gagal didaftar !!');
        }
        return redirect('/');
    }

    public function index(){
        $user = User::with('roleRelasi')->where('status', 2)->get();
        $user_aktivasi = User::with('roleRelasi')->where('status', 1)->get();
        return view('pengguna sistem.pengguna-sistem', [
            'data' => $user,
            'user_aktivasi' => $user_aktivasi
        ]);
    }

    public function delete($id){
        $user = User::FindOrFail($id);
        $path = '../public/storage/foto profil/'.$user->foto_profil;
            if(File::exists($path)){
                File::delete($path);
            }
        $user->delete();
            if($user){
                Session::flash('status', 'success');
                Session::flash('pesan', 'Data berhasil dihapus !!');
            }else{
                Session::flash('status', 'error');
                Session::flash('pesan', 'Data Gagal dihapus !!');
            }
        return redirect('/pengguna-sistem');
    }

    public function edit($id){
        $user =User::FindOrFail($id);
        $role = RoleModel::get();
        return view('pengguna sistem.pengguna-sistem-edit', [
            'data' => $user,
            'role' => $role
        ]);
    }

    public function update(Request $request, $id){
        $user = User::FindOrFail($id);
        if($request->hasFile('image')){
            $path = '../public/storage/foto profil/'.$user->foto_profil;
            if(File::exists($path)){
                File::delete($path);
            }
                $ektension = $request->file('image')->getClientOriginalExtension();
                $newname = $request->username.'-'.now()->timestamp.'.'.$ektension;
                $request->file('image')->storeAs('foto profil', $newname);
                $request['foto_profil'] = $newname;
        }
        $user->update($request->all());
        if($user){
            Session::flash('status', 'success');
            Session::flash('pesan', 'Data berhasil diedit !!');
        }else{
            Session::flash('status', 'error');
            Session::flash('pesan', 'Data Gagal diedit !!');
        }
        return redirect('/pengguna-sistem');
    }

    public function resetPassword(Request $request, $id){
        $passwordNew = '12345678';
        $user = User::FindOrFail($id);
        $request['password'] = Hash::make($passwordNew);
        $user->update($request->all());
        if($user){
            Session::flash('status', 'success');
            Session::flash('pesan', 'Password berhasil direset !!');
        }else{
            Session::flash('status', 'error');
            Session::flash('pesan', 'Password gagal direset !!');
        }
        return redirect('/pengguna-sistem');
    }

    public function AccUser(Request $request, $id){
        $user = User::FindOrFail($id);
        $request['status'] = 2;
        $user->update($request->all());
        if($user){
            Session::flash('status', 'success');
            Session::flash('pesan', 'Akun berhasil diaktivasi !!');
        }else{
            Session::flash('status', 'error');
            Session::flash('pesan', 'Akun gagal diaktivasi !!');
        }
        return redirect('/pengguna-sistem');
    }

    public function TolakUser($id){
        $user = User::FindOrFail($id);
        $user->delete();
        if($user){
            Session::flash('status', 'success');
            Session::flash('pesan', 'Akun berhasil ditolak !!');
        }else{
            Session::flash('status', 'error');
            Session::flash('pesan', 'Akun Gagal ditolak !!');
        }
    return redirect('/pengguna-sistem');

    }

    public function setting(Request $request, $id){
        $user = User::FindOrFail($id);
        if($request->hasFile('image')){
            $path = '../public/storage/foto profil/'.$user->foto_profil;
            if(File::exists($path)){
                File::delete($path);
            }
                $ektension = $request->file('image')->getClientOriginalExtension();
                $newname = $request->username.'-'.now()->timestamp.'.'.$ektension;
                $request->file('image')->storeAs('foto profil', $newname);
                $request['foto_profil'] = $newname;
        }
        $password = $user->password;
        if($request['password'] == ''){
            $request['password'] = $password;
        }else{
            $request['password'] = Hash::make($request->password);
        }
        $user->update($request->all());
        if($user){
            Session::flash('status', 'success');
            Session::flash('pesan', 'Data berhasil diubah !!');
        }else{
            Session::flash('status', 'error');
            Session::flash('pesan', 'Data Gagal diubah !!');
        }
        return redirect('/dashboard');
    }
}   
