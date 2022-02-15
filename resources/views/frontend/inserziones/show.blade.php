@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.inserzione.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.inserziones.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.inserzione.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $inserzione->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.inserzione.fields.categoria') }}
                                    </th>
                                    <td>
                                        {{ $inserzione->categoria->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.inserzione.fields.broker') }}
                                    </th>
                                    <td>
                                        {{ $inserzione->broker }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.inserzione.fields.fondo_iniziale') }}
                                    </th>
                                    <td>
                                        {{ $inserzione->fondo_iniziale }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.inserzione.fields.fondo_finale') }}
                                    </th>
                                    <td>
                                        {{ $inserzione->fondo_finale }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.inserzione.fields.percentage') }}
                                    </th>
                                    <td>
                                        {{ $inserzione->percentage }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.inserzione.fields.estratto') }}
                                    </th>
                                    <td>
                                        @if($inserzione->estratto)
                                            <a href="{{ $inserzione->estratto->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.inserziones.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection