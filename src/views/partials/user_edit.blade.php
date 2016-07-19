<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    <span>{{ Session::get('success') }}</span>
                </div>
            @endif
        	<div class="panel panel-default">
                <div class="panel-heading">{{ $user->displayName() }}</div>
                <div class="panel-body">
                </div>
            </div>
        </div>
    </div>
</div>
