<?php

namespace App\Http\Controllers;

use App\Section;

class SectionController extends Controller
{
    /**
     * Листинг отделов
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('pages.sections.index');
    }

    /**
     * Создание отдела
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('pages.sections.form', [
            'section' => null,
        ]);
    }

    /**
     * Редактирование отдела
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $section = Section::with('users')
            ->find($id);

        return view('pages.sections.form', [
            'section' => $section,
        ]);
    }

}
