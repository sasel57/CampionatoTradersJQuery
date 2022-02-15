<?php

namespace App\Http\Controllers\Frontend;

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

class InserzioneController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('inserzione_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inserziones = Inserzione::with(['categoria', 'created_by', 'media'])->get();

        return view('frontend.inserziones.index', compact('inserziones'));
    }

    public function create()
    {
        abort_if(Gate::denies('inserzione_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categorias = Categorium::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.inserziones.create', compact('categorias'));
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

        return redirect()->route('frontend.inserziones.index');
    }

    public function edit(Inserzione $inserzione)
    {
        abort_if(Gate::denies('inserzione_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categorias = Categorium::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $inserzione->load('categoria', 'created_by');

        return view('frontend.inserziones.edit', compact('categorias', 'inserzione'));
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

        return redirect()->route('frontend.inserziones.index');
    }

    public function show(Inserzione $inserzione)
    {
        abort_if(Gate::denies('inserzione_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inserzione->load('categoria', 'created_by');

        return view('frontend.inserziones.show', compact('inserzione'));
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
