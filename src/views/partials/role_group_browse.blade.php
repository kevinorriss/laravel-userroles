<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    <span>{{ Session::get('success') }}</span>
                </div>
            @endif
        	<div class="panel panel-default">
                <div class="panel-heading">
                    <span>Role Groups</span>
                    @if (Auth::user()->hasRole('role_group_create'))
                        <a class="pull-right" href="{{ route('role_groups.create') }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create Role Group</a>
                    @endif
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">
                            @for ($i = $col1_start; $i < $col2_start; $i++)
                                <p><a href="{{ route('role_groups.show', $role_groups[$i]->id) }}" title="{{ $role_groups[$i]->description }}">{{ $role_groups[$i]->name }}</a></p>
                            @endfor
                        </div>
                        <div class="col-sm-4">
                            @for ($i = $col2_start; $i < $col3_start; $i++)
                                <p><a href="{{ route('role_groups.show', $role_groups[$i]->id) }}" title="{{ $role_groups[$i]->description }}">{{ $role_groups[$i]->name }}</a></p>
                            @endfor
                        </div>
                        <div class="col-sm-4">
                            @for ($i = $col3_start; $i < $count; $i++)
                                <p><a href="{{ route('role_groups.show', $role_groups[$i]->id) }}" title="{{ $role_groups[$i]->description }}">{{ $role_groups[$i]->name }}</a></p>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
