<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\sections\StoreRequest;
use App\Http\Requests\API\sections\UpdateRequest;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\File;

class SectionController extends Controller
{

    private $sections;

    public function __construct(Section $section)
    {
        $this->sections = $section;
    }
    /**
     * Листинг отделов
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $per_page = request('per_page', 10);

        $sections = $this->sections
            ->with(['users' => function ($query) {
                $query->orderByDesc('id');
            }])
            ->orderByDesc('id')
            ->paginate($per_page);

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

        if ($request->file('logo')) {
            $data['logo'] = $request->file('logo')
                ->store('logo', 'public');
        }

        $section = $this->sections
            ->create($data);

        $section->users()
            ->sync($request->user_ids);

        return $this->getJson($section);
    }

    /**
     * Просмотр отдела
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $section = $this->sections
            ->find($id);

        return $this->getJson($section);
    }

    /**
     * Изменение отдела
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->input();

        $section = $this->sections
            ->find($id);

        if ($request->file('logo')) {
            if ($section->logo) {
                Storage::delete($section->logo);
            }
            $data['logo'] = $request->file('logo')
                ->store('logo', 'public');
        }

        $section->update($data);

        $section->users()
            ->sync($request->user_ids);

        return $this->getJson($section);
    }

    /**
     * Удаление отдела
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = $this->sections
            ->find($id);

        if ($section->logo) {
            Storage::delete($section->logo);
        }
        $section->delete();

        return $this->getJson(null);
    }
}
