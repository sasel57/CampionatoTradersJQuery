<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCategoriumRequest;
use App\Http\Requests\StoreCategoriumRequest;
use App\Http\Requests\UpdateCategoriumRequest;
use App\Models\Categorium;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoriaController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('categorium_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categoria = Categorium::with(['created_by'])->get();

        return view('frontend.categoria.index', compact('categoria'));
    }

    public function create()
    {
        abort_if(Gate::denies('categorium_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.categoria.create');
    }

    public function store(StoreCategoriumRequest $request)
    {
        $categorium = Categorium::create($request->all());

        return redirect()->route('frontend.categoria.index');
    }

    public function edit(Categorium $categorium)
    {
        abort_if(Gate::denies('categorium_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categorium->load('created_by');

        return view('frontend.categoria.edit', compact('categorium'));
    }

    public function update(UpdateCategoriumRequest $request, Categorium $categorium)
    {
        $categorium->update($request->all());

        return redirect()->route('frontend.categoria.index');
    }

    public function show(Categorium $categorium)
    {
        abort_if(Gate::denies('categorium_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categorium->load('created_by');

        return view('frontend.categoria.show', compact('categorium'));
    }

    public function destroy(Categorium $categorium)
    {
        abort_if(Gate::denies('categorium_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categorium->delete();

        return back();
    }

    public function massDestroy(MassDestroyCategoriumRequest $request)
    {
        Categorium::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
