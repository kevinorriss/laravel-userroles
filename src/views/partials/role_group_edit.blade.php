<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (Session::has('error'))
                <div class="alert alert-danger">
                    <span>{{ Session::get('error') }}</span>
                </div>
            @endif
        	<div class="panel panel-default">
                <div class="panel-heading">Edit Role Group</div>
                <div class="panel-body">
                    {!! Form::open(['url' => route('role_groups.update', $role_group->id), 'method' => 'PUT', 'class' => 'form-horizontal', 'role' => 'form']) !!}

                        <!-- Name -->
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!! Form::label('name', 'Name', ['class' => 'col-md-4 control-label text-primary']) !!}
                            <div class="col-md-6">
                                {!! Form::text('name', old('name', $role_group->name), ['class' => 'form-control', 'placeholder' => 'role_group_name']) !!}
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
                                {!! Form::textarea('description', old('description', $role_group->description), ['class' => 'form-control', 'placeholder' => 'A description about what the role group allows']) !!}
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('roles', 'Roles', ['class' => 'col-md-4 control-label text-primary']) !!}
                            <div class="col-md-8">
                                @foreach($roles as $role)
                                    <div class="checkbox">
                                        <label title="{{ $role->description }}">
                                            {{Form::checkbox('roles[]', $role->id, old('roles.' . $role->id, in_array($role->id, $selected_roles ?? array())))}}
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('sub_groups', 'Role Groups', ['class' => 'col-md-4 control-label text-primary']) !!}
                            <div class="col-md-8">
                                @foreach($sub_groups as $sub_group)
                                    <div class="checkbox">
                                        <label title="{{ $sub_group->description }}">
                                            {{Form::checkbox('sub_groups[]', $sub_group->id, old('sub_groups.' . $sub_group->id, in_array($sub_group->id, $selected_sub_groups ?? array())), [$sub_group->id == $role_group->id ? "disabled" : ""])}}
                                            {{ $sub_group->name }}
                                        </label>
                                    </div>
                                @endforeach
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
                                <a class="btn btn-default" href="{{ route('role_groups.show', $role_group->id) }}">Cancel</a>
                            </div>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
