<?php

namespace App\Repositories;

use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository
{

    /**
     * Создание репозитория
     *
     * @param App\User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Создать секцию
     *
     * @param array $data
     * @return App\User
     */
    public function store(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        $user = $this->model
            ->create($data);

        return $user;
    }

    /**
     * Получить всех пользователей
     */
    public function getAll(): Collection
    {
        $users = $this->model
            ->all();
        return $users;
    }

    /**
     * Получить пагинируемый листинг пользователей
     *
     * @param int $page
     * @param int $per_page
     * @return LengthAwarePaginator
     */
    public function getIndex(int $page, int $per_page): LengthAwarePaginator
    {
        $columns = ['id', 'name', 'email', 'created_at'];

        $users = $this->model
            ->select($columns)
            ->orderByDesc('id')
            ->paginate($per_page);

        return $users;
    }

    /**
     * Получить пользователя
     *
     * @param int $id
     * @return App\User
     */
    public function getShow(int $id): User
    {
        $columns = ['id', 'name', 'email'];

        $user = $this->model
            ->select($columns)
            ->find($id);

        return $user;
    }

    /**
     * Обновить пользователя
     *
     * @param int $id
     * @param array $data
     * @return App\User
     */
    public function update(int $id, array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user = $this->model
            ->find($id);

        $user->update($data);

        return $user;
    }

    /**
     * Удалить пользователя
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $user = $this->model
            ->find($id);

        $user->delete();

        return true;
    }

}
