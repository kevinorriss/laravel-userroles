<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    <span>{{ Session::get('success') }}</span>
                </div>
            @endif
        	<div class="panel panel-default">
                <div class="panel-heading">Show Role Group</div>
                <div class="panel-body">
                    <p>
                        <strong class="text-primary">Name</strong><br/>
                        <span>{{ $role_group->name }}</span>
                    </p>
                    <p>
                        <strong class="text-primary">Description</strong><br/>
                        <span>{{ $role_group->description }}</span>
                    </p>
                    <p>
                        <strong class="text-primary">Roles</strong><br/>
                        @if(count($roles) > 0)
                            @foreach($roles as $role)
                                <a href="{{ route('roles.show', $role->id) }}" title="{{ $role->description }}">{{ $role->name }}</a><br/>
                            @endforeach
                        @else
                            <span>This role group has no roles assigned</span>
                        @endif
                    </p>
                    <p>
                        <strong class="text-primary">Role Groups</strong><br/>
                        @if(count($sub_groups) > 0)
                            @foreach($sub_groups as $sub_group)
                                <a href="{{ route('role_groups.show', $sub_group->id) }}" title="{{ $sub_group->description }}">{{ $sub_group->name }}</a><br/>
                            @endforeach
                        @else
                            <span>This role group has no sub role groups assigned</span>
                        @endif
                    </p>
                    <hr/>
                    @if (Auth::user()->hasRole('role_group_edit'))
                        <a href="{{ route('role_groups.edit', $role_group->id) }}" class="btn btn-primary">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            <span>Edit</span>
                        </a>
                    @endif
                    <a class="btn btn-default" href="{{ route('role_groups.index') }}">Browse Role Groups</a>
                    @if (Auth::user()->hasRole('role_group_delete'))
                        {!! Form::open(['url' => route('role_groups.destroy', $role_group->id), 'method' => 'DELETE', 'class' => 'form-horizontal pull-right', 'role' => 'form']) !!}
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
