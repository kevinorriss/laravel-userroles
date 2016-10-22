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
                        @if (count($roles) == 0)
                            <div class="col-md-12">
                                <p class="text-center">There are no roles created</p>
                            </div>
                        @else
                            @foreach ($roles as $role)
                                
                                @if ($role->trashed() && !Auth::user()->hasRole('role_restore'))
                                    @continue
                                @endif

                                <div class="col-md-4">
                                    <a class="{{ $role->trashed() ? 'text-danger' : '' }}"
                                        href="{{ route('roles.show', $role->id) }}" 
                                        title="{{ $role->description }}">
                                        <p>{{ $role->name }}</p>
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