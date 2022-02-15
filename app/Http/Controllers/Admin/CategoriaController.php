<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCategoriumRequest;
use App\Http\Requests\StoreCategoriumRequest;
use App\Http\Requests\UpdateCategoriumRequest;
use App\Models\Categorium;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('categorium_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Categorium::with(['created_by'])->select(sprintf('%s.*', (new Categorium())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'categorium_show';
                $editGate = 'categorium_edit';
                $deleteGate = 'categorium_delete';
                $crudRoutePart = 'categoria';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.categoria.index');
    }

    public function create()
    {
        abort_if(Gate::denies('categorium_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categoria.create');
    }

    public function store(StoreCategoriumRequest $request)
    {
        $categorium = Categorium::create($request->all());

        return redirect()->route('admin.categoria.index');
    }

    public function edit(Categorium $categorium)
    {
        abort_if(Gate::denies('categorium_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categorium->load('created_by');

        return view('admin.categoria.edit', compact('categorium'));
    }

    public function update(UpdateCategoriumRequest $request, Categorium $categorium)
    {
        $categorium->update($request->all());

        return redirect()->route('admin.categoria.index');
    }

    public function show(Categorium $categorium)
    {
        abort_if(Gate::denies('categorium_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categorium->load('created_by');

        return view('admin.categoria.show', compact('categorium'));
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
