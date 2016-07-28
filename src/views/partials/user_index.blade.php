<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">User Roles</div>
                <div class="panel-body">
                    @if($count > 0)
                        <div class="row">
                            <div class="col-md-12">
                                {!! $users->links() !!}
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        @if ($count == 0)
                            <div class="col-md-12">
                                <p class="text-center">No users found</p>
                            </div>
                        @else
                            <div class="col-sm-4">
                                @for ($i = $col1_start; $i < min($col2_start, $count); $i++)
                                    <p><a href="{!! route('user_roles.show', $users->items()[$i]->$user_id_column) !!}" title="View user's roles">{{ $users->items()[$i]->$user_name_column }}</a></p>
                                @endfor
                            </div>
                            <div class="col-sm-4">
                                @for ($i = $col2_start; $i < min($col3_start, $count); $i++)
                                    <p><a href="{!! route('user_roles.show', $users->items()[$i]->$user_id_column) !!}" title="View user's roles">{{ $users->items()[$i]->$user_name_column }}</a></p>
                                @endfor
                            </div>
                            <div class="col-sm-4">
                                @for ($i = $col3_start; $i < $count; $i++)
                                    <p><a href="{!! route('user_roles.show', $users->items()[$i]->$user_id_column) !!}" title="View user's roles">{{ $users->items()[$i]->$user_name_column }}</a></p>
                                @endfor
                            </div>
                        @endif
                    </div>
                    @if($count > 0)
                        <div class="row">
                            <div class="col-md-12">
                                {!! $users->links() !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
