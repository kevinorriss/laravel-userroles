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
                        @if (count($role_groups) == 0)
                            <div class="col-md-12">
                                <p class="text-center">There are no role groups created</p>
                            </div>
                        @else
                            @foreach($role_groups as $role_group)

                                @if ($role_group->trashed() && !Auth::user()->hasRole('role_group_restore'))
                                    @continue
                                @endif

                                <div class="col-md-4">
                                    <a class="{{ $role_group->trashed() ? 'text-danger' : '' }}"
                                        href="{{ route('role_groups.show', $role_group->id) }}" 
                                        title="{{ $role_group->description }}">
                                        <p>{{ $role_group->name }}</p>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
