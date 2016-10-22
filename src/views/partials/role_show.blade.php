<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    <span>{{ Session::get('success') }}</span>
                </div>
            @endif
        	<div class="panel panel-default">
                <div class="panel-heading">Show Role</div>
                <div class="panel-body">
                    <p>
                        <strong class="text-primary">Name</strong><br/>
                        <span>{{ $role->name }}</span>
                    </p>
                    <p>
                        <strong class="text-primary">Description</strong><br/>
                        <span>{{ $role->description }}</span>
                    </p>
                    <hr/>
                    @if (!$role->trashed() && Auth::user()->hasRole('role_edit'))
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            <span>Edit</span>
                        </a>
                    @endif
                    @if (Auth::user()->hasRole('role_browse'))
                        <a class="btn btn-default" href="{{ route('roles.index') }}">
                            <span>Browse Roles</span>
                        </a>
                    @endif
                    @if (!$role->trashed() && Auth::user()->hasRole('role_delete'))
                        {!! Form::open(['url' => route('roles.destroy', $role->id), 'method' => 'DELETE', 'class' => 'form-horizontal pull-right', 'role' => 'form']) !!}
                            <button type="submit" class="btn btn-danger">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                <span>Delete</span>
                            </button>
                        {!! Form::close() !!}
                    @elseif ($role->trashed())
                        @if (Auth::user()->hasRole('role_destroy'))
                            {!! Form::open(['url' => route('roles.destroy', $role->id), 'method' => 'DELETE', 'class' => 'form-horizontal pull-right', 'role' => 'form']) !!}
                            <button type="submit" class="btn btn-danger">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                <span>Destroy</span>
                            </button>
                        {!! Form::close() !!}
                        @endif
                        @if (Auth::user()->hasRole('role_restore'))
                            {!! Form::open(['url' => route('roles.update', $role->id), 'method' => 'PUT', 'class' => 'form-horizontal pull-right', 'role' => 'form', 'style' => 'margin-right:4px;']) !!}
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>
                                    <span>Restore</span>
                                </button>
                            {!! Form::close() !!}
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
