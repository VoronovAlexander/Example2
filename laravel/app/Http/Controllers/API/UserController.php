<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\users\StoreRequest;
use App\Http\Requests\API\users\UpdateRequest;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $userRepository;

    /**
     * Создание UserController
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Все пользователи
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $users = $this->userRepository
            ->getAll();
        return $this->getJson($users);
    }

    /**
     * Листинг пользователей
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = (int) $request->input('page', 1);
        $per_page = (int) $request->input('per_page', 10);

        $users = $this->userRepository
            ->getIndex($page, $per_page);

        return $this->getJsonPaginate($users);
    }

    /**
     * Создание нового пользователя
     *
     * @param  App\Http\Requests\API\users\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->input();

        $user = $this->userRepository
            ->store($data);

        return $this->getJson($user);
    }

    /**
     * Просмотр пользователя
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $user = $this->userRepository
            ->getShow($id);

        return $this->getJson($user);
    }

    /**
     * Изменение пользователя
     *
     * @param  App\Http\Requests\API\users\UpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, int $id)
    {
        $data = $request->input();

        $user = $this->userRepository
            ->update($id, $data);

        return $this->getJson($user);
    }

    /**
     * Удаление пользователя
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->userRepository
            ->destroy($id);

        return $this->getJson(null);
    }
}
