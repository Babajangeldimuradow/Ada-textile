<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    // User listini görkezmek
    public function index()
    {
        $users = User::orderBy('id', 'ASC')->paginate(10);
        return view('backend.users.index', compact('users'));
    }

    // User goşmak üçin formy açmak
    public function create()
    {
        $roles = ['admin', 'user']; // Static role list
        return view('backend.users.create', compact('roles'));
    }

    // User saklamak
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:5',
            'role' => 'required|string|in:admin,user',
            'status' => 'required|string|in:active,inactive',
            'photo' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        $status = User::create($data);

        if ($status) {
            session()->flash('success', 'Ulanyjy üstünlikli döredildi!');
        } else {
            session()->flash('error', 'Ulanyjy döredilende ýalňyşlyk ýüze çykdy.');
        }

        return redirect()->route('users.index');
    }

    // User edit etmek üçin form açmak
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = ['admin', 'user']; // Static role list
        return view('backend.users.edit', compact('user', 'roles'));
    }

    // User update etmek
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:users,name,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|string|min:5',
            'role' => 'required|string|in:admin,user',
            'status' => 'required|string|in:active,inactive',
            'photo' => 'nullable|string',
        ]);

        $data = $request->all();

        // Password üýtgeýän bolsa hash etmek
        if(!empty($data['password'])){
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // Password boş bolsa üýtgetme
        }

        $status = $user->fill($data)->save();

        if ($status) {
            session()->flash('success','Ulanyjy üstünlikli täzelendi!');
        } else {
            session()->flash('error','Ulanyjy täzelenende säwlik ýüze çykdy.');
        }

        return redirect()->route('users.index');
    }

    // User pozmak
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $status = $user->delete();

        if ($status) {
            session()->flash('success','Ulanyjy üstünlikli pozuldy!');
        } else {
            session()->flash('error','Ulanyjy pozulanda säwlik ýüze çykdy.');
        }

        return redirect()->route('users.index');
    }
}
