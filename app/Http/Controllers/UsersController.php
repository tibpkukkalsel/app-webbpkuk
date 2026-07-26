<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brick\Math\BigInteger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    public function view(){

        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('admin.pengguna.view', compact('users', 'roles'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role'     => 'required|exists:roles,name',
        ]);

        try {

            DB::beginTransaction();

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole($request->role);

            DB::commit();

            return back()->with('success', 'Data berhasil disimpan.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('warning', 'Data gagal disimpan.');
        }
    }

    public function edit(Request $request){

        $id = $request->id;
        $id = Crypt::decrypt($id);

        $users = User::where('id', $id)->first();
        $roles = Role::all();

        return view('admin.pengguna.edit', compact('users', 'roles'));

    }

    public function update(Request $request){

        $id   = $request->id;
        $id   = Crypt::decrypt($id);
        $nama      = $request->nama;
        $email     = $request->email;
        $password  = $request->password;
        if ($password == null ){
            $data   = [
                'name' => $nama,
                'email'    =>$email
            ];
        }else {
        $data       = [
            'name'     => $nama,
            'email'    => $email,
            'password' => Hash::make($password)
        ];}

        $user = User::where('id', $id)->first();
        $update = $user->update($data);

        if ($request->has('role') && $request->role != '') {
            $user->syncRoles($request->role);
        }

        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Diubah']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Diubah']);
        }
        
    }

    public function delete(string $id){

        $id = Crypt::decrypt($id);

        $delete = User::where('id',$id)->delete();

        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    }



}
