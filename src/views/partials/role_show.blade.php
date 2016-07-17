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
                    @if (Auth::user()->hasRole('role_edit'))
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            <span>Edit</span>
                        </a>
                    @endif
                    <a class="btn btn-default" href="{{ route('roles.index') }}">Browse Roles</a>
                    @if (Auth::user()->hasRole('role_delete'))
                        {!! Form::open(['url' => route('roles.destroy', $role->id), 'method' => 'DELETE', 'class' => 'form-horizontal pull-right', 'role' => 'form']) !!}
                        <button type="submit" class="btn btn-danger">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            <span>Delete</span>
                        </button>
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
