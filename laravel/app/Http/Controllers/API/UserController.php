<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\users\StoreRequest;
use App\Http\Requests\API\users\UpdateRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Все пользователи
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $users = $this->user->all();
        return $this->getJson($users);
    }

    /**
     * Листинг пользователя
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $per_page = request('per_page', 10);

        $users = $this->user
            ->orderByDesc('id')
            ->paginate($per_page);

        return $this->getJsonPaginate($users);
    }

    /**
     * Создание нового пользователя
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->input();

        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        }

        $user = $this->user
            ->create($data);

        return $this->getJson($user);
    }

    /**
     * Просмотр пользователя
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->user
            ->find($id);

        return $this->getJson($user);
    }

    /**
     * Изменение пользователя
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->input();

        if ($request->has('password')) {
            if ($data['password'] == null) {
                unset($data['password']);
            } else {
                $data['password'] = Hash::make($data['password']);
            }
        }

        $user = $this->user->find($id);

        $user = $user->update($data);

        return $this->getJson($user);

    }

    /**
     * Удаление пользователя
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->user->find($id);
        $user = $user->delete();
        return $this->getJson($user);
    }
}
