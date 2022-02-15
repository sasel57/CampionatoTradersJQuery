@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.users.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}" required>
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="username">{{ trans('cruds.user.fields.username') }}</label>
                <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" type="text" name="username" id="username" value="{{ old('username', '') }}" required>
                @if($errors->has('username'))
                    <span class="text-danger">{{ $errors->first('username') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.username_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" required>
                @if($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple required>
                    @foreach($roles as $id => $role)
                        <option value="{{ $id }}" {{ in_array($id, old('roles', [])) ? 'selected' : '' }}>{{ $role }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                    <span class="text-danger">{{ $errors->first('roles') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="address">{{ trans('cruds.user.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', '') }}" required>
                @if($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="comune">{{ trans('cruds.user.fields.comune') }}</label>
                <input class="form-control {{ $errors->has('comune') ? 'is-invalid' : '' }}" type="text" name="comune" id="comune" value="{{ old('comune', '') }}" required>
                @if($errors->has('comune'))
                    <span class="text-danger">{{ $errors->first('comune') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.comune_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="country">{{ trans('cruds.user.fields.country') }}</label>
                <input class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" type="text" name="country" id="country" value="{{ old('country', '') }}" required>
                @if($errors->has('country'))
                    <span class="text-danger">{{ $errors->first('country') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.country_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="cap">{{ trans('cruds.user.fields.cap') }}</label>
                <input class="form-control {{ $errors->has('cap') ? 'is-invalid' : '' }}" type="text" name="cap" id="cap" value="{{ old('cap', '') }}" required>
                @if($errors->has('cap'))
                    <span class="text-danger">{{ $errors->first('cap') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.cap_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="phone">{{ trans('cruds.user.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}" required>
                @if($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_active') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" required {{ old('is_active', 0) == 1 || old('is_active') === null ? 'checked' : '' }}>
                    <label class="required form-check-label" for="is_active">{{ trans('cruds.user.fields.is_active') }}</label>
                </div>
                @if($errors->has('is_active'))
                    <span class="text-danger">{{ $errors->first('is_active') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.is_active_helper') }}</span>
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