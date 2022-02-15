<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyInserzioneRequest;
use App\Http\Requests\StoreInserzioneRequest;
use App\Http\Requests\UpdateInserzioneRequest;
use App\Models\Categorium;
use App\Models\Inserzione;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class InserzioneController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('inserzione_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Inserzione::with(['categoria', 'created_by'])->select(sprintf('%s.*', (new Inserzione())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'inserzione_show';
                $editGate = 'inserzione_edit';
                $deleteGate = 'inserzione_delete';
                $crudRoutePart = 'inserziones';

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
            $table->addColumn('categoria_name', function ($row) {
                return $row->categoria ? $row->categoria->name : '';
            });

            $table->editColumn('broker', function ($row) {
                return $row->broker ? $row->broker : '';
            });
            $table->editColumn('fondo_iniziale', function ($row) {
                return $row->fondo_iniziale ? $row->fondo_iniziale : '';
            });
            $table->editColumn('fondo_finale', function ($row) {
                return $row->fondo_finale ? $row->fondo_finale : '';
            });
            $table->editColumn('percentage', function ($row) {
                return $row->percentage ? $row->percentage : '';
            });
            $table->editColumn('estratto', function ($row) {
                return $row->estratto ? '<a href="' . $row->estratto->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'categoria', 'estratto']);

            return $table->make(true);
        }

        return view('admin.inserziones.index');
    }

    public function create()
    {
        abort_if(Gate::denies('inserzione_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categorias = Categorium::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.inserziones.create', compact('categorias'));
    }

    public function store(StoreInserzioneRequest $request)
    {
        $inserzione = Inserzione::create($request->all());

        if ($request->input('estratto', false)) {
            $inserzione->addMedia(storage_path('tmp/uploads/' . basename($request->input('estratto'))))->toMediaCollection('estratto');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $inserzione->id]);
        }

        return redirect()->route('admin.inserziones.index');
    }

    public function edit(Inserzione $inserzione)
    {
        abort_if(Gate::denies('inserzione_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categorias = Categorium::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $inserzione->load('categoria', 'created_by');

        return view('admin.inserziones.edit', compact('categorias', 'inserzione'));
    }

    public function update(UpdateInserzioneRequest $request, Inserzione $inserzione)
    {
        $inserzione->update($request->all());

        if ($request->input('estratto', false)) {
            if (!$inserzione->estratto || $request->input('estratto') !== $inserzione->estratto->file_name) {
                if ($inserzione->estratto) {
                    $inserzione->estratto->delete();
                }
                $inserzione->addMedia(storage_path('tmp/uploads/' . basename($request->input('estratto'))))->toMediaCollection('estratto');
            }
        } elseif ($inserzione->estratto) {
            $inserzione->estratto->delete();
        }

        return redirect()->route('admin.inserziones.index');
    }

    public function show(Inserzione $inserzione)
    {
        abort_if(Gate::denies('inserzione_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inserzione->load('categoria', 'created_by');

        return view('admin.inserziones.show', compact('inserzione'));
    }

    public function destroy(Inserzione $inserzione)
    {
        abort_if(Gate::denies('inserzione_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inserzione->delete();

        return back();
    }

    public function massDestroy(MassDestroyInserzioneRequest $request)
    {
        Inserzione::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('inserzione_create') && Gate::denies('inserzione_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Inserzione();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
