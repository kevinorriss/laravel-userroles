<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        	<div class="panel panel-default">
                <div class="panel-heading">Create Role</div>
                <div class="panel-body">
                    {!! Form::open(['url' => route('roles.store'), 'method' => 'POST', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                        <!-- Name -->
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!! Form::label('name', 'Name', ['class' => 'col-md-4 control-label text-primary']) !!}
                            <div class="col-md-6">
                                {!! Form::text('name', old('name'), ['class' => 'form-control', 'autofocus' => 'autofocus', 'placeholder' => 'role_name']) !!}
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- Description -->
                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            {!! Form::label('description', 'Description', ['class' => 'col-md-4 control-label text-primary']) !!}
                            <div class="col-md-6">
                                {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'placeholder' => 'A description about what the role allows']) !!}
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <hr/>
                        <!-- Submit / Forgot -->
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                                    <span>Save</span>
                                </button>
                                <a class="btn btn-default" href="{{ route('roles.index') }}">Cancel</a>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
