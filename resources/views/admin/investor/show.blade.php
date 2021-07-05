@extends('admin.layout.index')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="row">

        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">User Info</h3>
                </div>
                <div class="box-body">
                    <form action="{{ url('admin/'.$url) }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label>User name</label>
                            <input type="text" name="username" id="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <button>Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
