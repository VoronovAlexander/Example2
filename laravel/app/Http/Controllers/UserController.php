<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    /**
     * Листинг пользователей
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('pages.users.index');
    }

    /**
     * Создание пользователя
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('pages.users.form', [
            'user' => null,
        ]);
    }

    /**
     * Редактирование пользователя
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('pages.users.form', [
            'user' => $user,
        ]);
    }

}
