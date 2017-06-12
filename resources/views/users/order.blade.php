@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <order-form inline-template>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="loading" v-if="is_loading">Loading</div>
                        <div class="form-group">
                            <label for="delivery_time">Delivery by</label>
                            <input class="form-control" type="text" name="delivery_time" id="delivery_time" v-model="delivery_time">
                        </div>
                        <div class="form-group">
                            <label for="driver_id">Delivery location:</label>
                            <input type="text" class="form-control" id="delivery_location" name="delivery_location" v-model="delivery_location">
                        </div>
                        <div class="form-group">
                            <label for="total">Total:</label>
                            <input type="text" class="form-control" id="total" name="total" v-model="total">
                        </div>
                        <div class="form-group">
                            <label for="driver_id">Driver ID:</label>
                            <input type="text" class="form-control" id="driver-id" name="driver_id" v-model="driver_id">
                        </div>
                        <button type="submit" class="btn btn-primary" v-text="action" @click="execute"></button>

                    </div>
                </div>
            </order-form>
        </div>
    </div>
</div>
@endsection
