<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\sections\StoreRequest;
use App\Http\Requests\API\sections\UpdateRequest;
use App\Repositories\SectionRepository;
use Illuminate\Http\Request;

class SectionController extends Controller
{

    private $sectionRepository;

    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }
    
    /**
     * Листинг отделов
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = (int) $request->input('page', 1);
        $per_page = (int) $request->input('per_page', 15);

        $sections = $this->sectionRepository
            ->getIndex($page, $per_page);

        return $this->getJsonPaginate($sections);
    }

    /**
     * Создание отдела
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->input();
        $data['logo'] = $request->file('logo');

        $section = $this->sectionRepository
            ->store($data);

        return $this->getJson($section);
    }

    /**
     * Просмотр отдела
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $section = $this->sectionRepository
            ->getShow($id);

        return $this->getJson($section);
    }

    /**
     * Изменение отдела
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, int $id)
    {
        $data = $request->input();
        $data['logo'] = $request->file('logo');

        $section = $this->sectionRepository
            ->update($id, $data);

        return $this->getJson($section);
    }

    /**
     * Удаление отдела
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->sectionRepository
            ->destroy($id);

        return $this->getJson(null);
    }
}
