@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.inserzione.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.inserziones.update", [$inserzione->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="categoria_id">{{ trans('cruds.inserzione.fields.categoria') }}</label>
                <select class="form-control select2 {{ $errors->has('categoria') ? 'is-invalid' : '' }}" name="categoria_id" id="categoria_id" required>
                    @foreach($categorias as $id => $entry)
                        <option value="{{ $id }}" {{ (old('categoria_id') ? old('categoria_id') : $inserzione->categoria->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('categoria'))
                    <span class="text-danger">{{ $errors->first('categoria') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inserzione.fields.categoria_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="broker">{{ trans('cruds.inserzione.fields.broker') }}</label>
                <input class="form-control {{ $errors->has('broker') ? 'is-invalid' : '' }}" type="text" name="broker" id="broker" value="{{ old('broker', $inserzione->broker) }}" required>
                @if($errors->has('broker'))
                    <span class="text-danger">{{ $errors->first('broker') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inserzione.fields.broker_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="fondo_iniziale">{{ trans('cruds.inserzione.fields.fondo_iniziale') }}</label>
                <input class="form-control {{ $errors->has('fondo_iniziale') ? 'is-invalid' : '' }}" type="number" name="fondo_iniziale" id="fondo_iniziale" value="{{ old('fondo_iniziale', $inserzione->fondo_iniziale) }}" step="0.01" required>
                @if($errors->has('fondo_iniziale'))
                    <span class="text-danger">{{ $errors->first('fondo_iniziale') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inserzione.fields.fondo_iniziale_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="fondo_finale">{{ trans('cruds.inserzione.fields.fondo_finale') }}</label>
                <input class="form-control {{ $errors->has('fondo_finale') ? 'is-invalid' : '' }}" type="number" name="fondo_finale" id="fondo_finale" value="{{ old('fondo_finale', $inserzione->fondo_finale) }}" step="0.01" required>
                @if($errors->has('fondo_finale'))
                    <span class="text-danger">{{ $errors->first('fondo_finale') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inserzione.fields.fondo_finale_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="percentage">{{ trans('cruds.inserzione.fields.percentage') }}</label>
                <input class="form-control {{ $errors->has('percentage') ? 'is-invalid' : '' }}" type="number" name="percentage" id="percentage" value="{{ old('percentage', $inserzione->percentage) }}" step="0.01" required>
                @if($errors->has('percentage'))
                    <span class="text-danger">{{ $errors->first('percentage') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.inserzione.fields.percentage_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="estratto">{{ trans('cruds.inserzione.fields.estratto') }}</label>
                <div class="needsclick dropzone {{ $errors->has('estratto') ? 'is-invalid' : '' }}" id="estratto-dropzone">
                </div>
                @if($errors->has('estratto'))
                    <span class="text-danger">{{ $errors->first('estratto') }}</span>
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



@endsection

@section('scripts')
<script>
    Dropzone.options.estrattoDropzone = {
    url: '{{ route('admin.inserziones.storeMedia') }}',
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