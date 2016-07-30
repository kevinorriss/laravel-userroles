<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        	<div class="panel panel-default">
                <div class="panel-heading">{{ $user->$user_name_column }}</div>
                <div class="panel-body">
                	{!! Form::open(['url' => route('user_roles.update', $user->$user_id_column), 'method' => 'PUT', 'class' => 'form-horizontal', 'role' => 'form']) !!}
        				@if (Auth::user()->hasRole('role_assign_user'))
	        				<div class="form-group">
	                            {!! Form::label('roles', 'Roles', ['class' => 'col-md-4 control-label text-primary']) !!}
	                            <div class="col-md-8">
	                                @foreach($roles as $role)
	                                    <div class="checkbox">
	                                        <label title="{{ $role->description }}">
	                                            {{Form::checkbox('roles[]', $role->id, old('roles.' . $role->id, $user_roles->contains($role))) }}
	                                            {{ $role->name }}
	                                        </label>
	                                    </div>
	                                @endforeach
	                            </div>
	                        </div>
                        @endif
                        @if (Auth::user()->hasRole('role_group_assign_user'))
	        				<div class="form-group">
	                            {!! Form::label('role_groups', 'Role Groups', ['class' => 'col-md-4 control-label text-primary']) !!}
	                            <div class="col-md-8">
	                                @foreach($role_groups as $role_group)
	                                    <div class="checkbox">
	                                        <label title="{{ $role_group->description }}">
	                                            {{Form::checkbox('role_groups[]', $role_group->id, old('role_groups.' . $role_group->id, $user_role_groups->contains($role_group))) }}
	                                            {{ $role_group->name }}
	                                        </label>
	                                    </div>
	                                @endforeach
	                            </div>
	                        </div>
                        @endif
                		<hr/>
                        <!-- Submit / Forgot -->
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                                    <span>Save</span>
                                </button>
                                <a class="btn btn-default" href="{{ route('user_roles.show', $user->$user_id_column) }}">Cancel</a>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
