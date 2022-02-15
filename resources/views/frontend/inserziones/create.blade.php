@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.inserzione.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.inserziones.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="categoria_id">{{ trans('cruds.inserzione.fields.categoria') }}</label>
                            <select class="form-control select2" name="categoria_id" id="categoria_id" required>
                                @foreach($categorias as $id => $entry)
                                    <option value="{{ $id }}" {{ old('categoria_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('categoria'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('categoria') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.inserzione.fields.categoria_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="broker">{{ trans('cruds.inserzione.fields.broker') }}</label>
                            <input class="form-control" type="text" name="broker" id="broker" value="{{ old('broker', '') }}" required>
                            @if($errors->has('broker'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('broker') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.inserzione.fields.broker_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="fondo_iniziale">{{ trans('cruds.inserzione.fields.fondo_iniziale') }}</label>
                            <input class="form-control" type="number" name="fondo_iniziale" id="fondo_iniziale" value="{{ old('fondo_iniziale', '') }}" step="0.01" required>
                            @if($errors->has('fondo_iniziale'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('fondo_iniziale') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.inserzione.fields.fondo_iniziale_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="fondo_finale">{{ trans('cruds.inserzione.fields.fondo_finale') }}</label>
                            <input class="form-control" type="number" name="fondo_finale" id="fondo_finale" value="{{ old('fondo_finale', '') }}" step="0.01" required>
                            @if($errors->has('fondo_finale'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('fondo_finale') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.inserzione.fields.fondo_finale_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="percentage">{{ trans('cruds.inserzione.fields.percentage') }}</label>
                            <input class="form-control" type="number" name="percentage" id="percentage" value="{{ old('percentage', '') }}" step="0.01" required>
                            @if($errors->has('percentage'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('percentage') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.inserzione.fields.percentage_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="estratto">{{ trans('cruds.inserzione.fields.estratto') }}</label>
                            <div class="needsclick dropzone" id="estratto-dropzone">
                            </div>
                            @if($errors->has('estratto'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('estratto') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.inserzione.fields.estratto_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    Dropzone.options.estrattoDropzone = {
    url: '{{ route('frontend.inserziones.storeMedia') }}',
    maxFilesize: 5, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').find('input[name="estratto"]').remove()
      $('form').append('<input type="hidden" name="estratto" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="estratto"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($inserzione) && $inserzione->estratto)
      var file = {!! json_encode($inserzione->estratto) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="estratto" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection