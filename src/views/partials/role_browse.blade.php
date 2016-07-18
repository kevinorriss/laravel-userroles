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
                    <span>Roles</span>
                    @if (Auth::user()->hasRole('role_create'))
                        <a class="pull-right" href="{{ route('roles.create') }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create Role</a>
                    @endif
                </div>
                <div class="panel-body">
                    <div class="row">
                        @if ($count == 0)
                            <div class="col-md-12">
                                <p class="text-center">There are no roles created</p>
                            </div>
                        @else
                            <div class="col-sm-4">
                                @for ($i = $col1_start; $i < min($col2_start, $count); $i++)
                                    <p><a href="{{ route('roles.show', $roles[$i]->id) }}" title="{{ $roles[$i]->description }}">{{ $roles[$i]->name }}</a></p>
                                @endfor
                            </div>
                            <div class="col-sm-4">
                                @for ($i = $col2_start; $i < min($col3_start, $count); $i++)
                                    <p><a href="{{ route('roles.show', $roles[$i]->id) }}" title="{{ $roles[$i]->description }}">{{ $roles[$i]->name }}</a></p>
                                @endfor
                            </div>
                            <div class="col-sm-4">
                                @for ($i = $col3_start; $i < $count; $i++)
                                    <p><a href="{{ route('roles.show', $roles[$i]->id) }}" title="{{ $roles[$i]->description }}">{{ $roles[$i]->name }}</a></p>
                                @endfor
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>