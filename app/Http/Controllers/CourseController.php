<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //Listar Cursos
    public function index()
    {
        $courses = Course::orderBy('name', 'desc')->get();

        // Carrega a view
        return view('courses.index', ['menu' => 'courses', 'cursos' => $courses]);
    }

    public function show(Course $course)
    {
        return view('courses.show', ['menu' => 'courses', 'course' => $course]);
    }
    // Carregar o formulario cadastrar curso

    public function create()
    {
        // Carrega a view
        return view('courses.create', ['menu' => 'courses']);
    }

    public function store(Request $request)
    {
        // Cadastrar no BD
        // dd($request);
        Course::create([
            'name' => $request->name
        ]);

        // Redireciona o usuario e envia mensagem de sucesso
        return redirect()->route('courses.index')->with('success', 'Curso cadastrado com sucesso!');
    }

    public function edit(Course $course)
    {
        return view('courses.edit', ['menu' => 'courses', 'course' => $course]);
    }

    public function update(Request $request, Course $course)
    {
        $course->update([
            'name' => $request->name
        ]);
        // Redireciona o usuario e envia mensagem de sucesso
        return redirect()->route('courses.show', ['menu' => 'courses', 'course' => $course->id])->with('success', 'Curso editado com sucesso!');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index', ['menu' => 'courses'])->with('success', 'Curso apagado!');
    }
}
