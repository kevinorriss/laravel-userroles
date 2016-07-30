<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    <span>{{ Session::get('success') }}</span>
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">{{ $user->$user_name_column }}</div>
                <div class="panel-body">
                    <p>
                        <strong class="text-primary">Roles</strong>
                        <br/>
                        @if (count($roles) == 0)
                            <span>There are no roles directly assigned to this user</span>
                        @else
                            @foreach($roles as $role)
                                <a href="{{ route('roles.show', $role->id) }}" title="{{ $role->description }}">{{ $role->name }}</a>
                            @endforeach
                        @endif
                    </p>
                    <p>
                        <strong class="text-primary">Role Groups</strong>
                        @if (count($role_groups) == 0)
                            <br/><span>There are no role groups directly assigned to this user</span>
                        @else
                            @foreach($role_groups as $role_group)
                                <br/><a href="{{ route('role_groups.show', $role_group->id) }}" title="{{ $role_group->description }}">{{ $role_group->name }}</a>
                            @endforeach
                        @endif
                    </p>
                    <hr/>
                    @if (Auth::user()->hasRole(['role_assign_user', 'role_group_assign_user']))
                        <a href="{{ route('user_roles.edit', $user->$user_id_column) }}" class="btn btn-primary">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            <span>Edit</span>
                        </a>
                    @endif
                    <a class="btn btn-default" href="{{ route('user_roles.index') }}">Browse User Roles</a>
                </div>
            </div>
        </div>
    </div>
</div>
