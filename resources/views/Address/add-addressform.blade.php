@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Address Form</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/address">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Address Line 1</label>

                            <div class="col-md-6">
                                <input id="address_line_1" type="address_line_1" class="form-control" name="address_line_1" value="{{ auth()->user()->address_line_1 }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Address Line 2</label>

                            <div class="col-md-6">
                                <input id="address_line_2" type="address_line_2" class="form-control" name="address_line_2" value="{{ auth()->user()->address_line_2 }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Town</label>

                            <div class="col-md-6">
                                <input id="town" type="town" class="form-control" name="town" value="{{ auth()->user()->town }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">State</label>

                            <div class="col-md-6">
                                <input id="state" type="state" class="form-control" name="state" value="{{ auth()->user()->state }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Postcode</label>

                            <div class="col-md-6">
                                <input id="postcode" type="postcode" class="form-control" name="postcode" value="{{ auth()->user()->postcode }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Country</label>

                            <div class="col-md-6">
                                <input id="country" type="country" class="form-control" name="country" value="Malaysia" disabled="">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
