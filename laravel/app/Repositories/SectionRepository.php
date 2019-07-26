<?php

namespace App\Repositories;

use App\Section;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class SectionRepository extends BaseRepository
{

    /**
     * Create a new SectionRepository
     *
     * @param App\Section $section
     */
    public function __construct(Section $section)
    {
        $this->model = $section;
    }

    /**
     * Создать секцию
     *
     * @param array $data
     * @return App\Section
     */
    public function store(array $data): Section
    {

        if (isset($data['logo'])) {
            $data['logo'] = $data['logo']
                ->store('logo', 'public');
        }

        $section = $this->model
            ->create($data);

        if (isset($data['user_ids'])) {
            $section->users()
                ->sync($data['user_ids']);
        }

        return $section;
    }

    /**
     * Получить пагинируемые секции
     *
     * @param int $page
     * @param int $per_page
     * @return LengthAwarePaginator
     */
    public function getIndex(int $page, int $per_page): LengthAwarePaginator
    {
        $columns = ['id', 'name', 'description', 'logo', 'created_at'];
        
        $sections = $this->model
            ->select($columns)
            ->with(['users' => function ($query) {
                $query->orderByDesc('id');
            }])
            ->orderByDesc('id')
            ->paginate($per_page);

        return $sections;
    }

    /**
     * Получить секцию
     *
     * @param int $id
     * @return App\Section
     */
    public function getShow(int $id): Section
    {
        $columns = ['id', 'name', 'description', 'logo'];

        $section = $this->model
            ->select($columns)
            ->find($id);

        return $section;
    }

    /**
     * Обновить секцию по id
     *
     * @param int $id
     * @param array $data
     * @return App\Section
     */
    public function update(int $id, array $data): Section
    {
        $section = $this->model
            ->find($id);

        if (isset($data['logo'])) {
            if ($section->logo) {
                Storage::delete($section->logo);
            }
            $data['logo'] = $data['logo']
                ->store('logo', 'public');
        }

        $section->update($data);

        if (isset($data['user_ids'])) {
            $section->users()
                ->sync($data['user_ids']);
        }

        return $section;
    }

    /**
     * Удалить секцию
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $section = $this->model
            ->find($id);

        if ($section->logo) {
            Storage::delete($section->logo);
        }
        $section->delete();

        return true;
    }

}
