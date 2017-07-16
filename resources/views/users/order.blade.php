@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <order-form inline-template>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="loading" v-if="is_loading" v-text="status">Loading</div>
                        <div class="form-group">
                            <label for="delivery_time">Delivery by</label>
                            <input class="form-control" type="text" name="delivery_time" id="delivery_time" v-model="delivery_time">
                        </div>
                        <div class="form-group">
                            <label for="driver_id">Delivery location:</label>
                            <gmap-autocomplete class="form-control"
                                @place_changed="setPlace">
                            </gmap-autocomplete>
                            or
                            <div class="form-group">
                                <address-selector :addresses="{{ auth()->user()->addresses->toJson() }}" @address_changed="updateAddress"></address-selector>
                                

                            </div>
                        </div>
                        <gmap-map :center="map_center" :zoom="zoom" style="height:300px" :scrollWheel="true" @center_changed="updateCenter" @position_changed="updateMarkerCenter">
                            <gmap-info-window :options="infoOptions" :position="infoWindowPos" :opened="infoWinOpen" :content="infoContent" @closeclick="infoWinOpen=false"></gmap-info-window>
                            <gmap-marker :position="marker_position" ref="markdelivery" :draggable="true" :clickable="true" @click="toggleInfoWindow()" @dragend="updateMarkerCenter"></gmap-marker>
                            
                        </gmap-map>
                        <div class="col-md-12 text-center">
                            <i>You can adjust the map marker to point to a more accurate location</i>
                        </div>
                        <h3>Delivery Address</h3>
                        
                        <div class="form-group">
                            <label for="total">Unit/House number:</label>
                            <input type="text" class="form-control" id="total" name="total" v-model="unit" required>
                        </div>
                        <div class="form-group">
                            <label for="total">Route:</label>
                            <input type="text" class="form-control" id="total" name="total" v-model="route" required>
                        </div>
                        <div class="form-group">
                            <label for="total">City:</label>
                            <input type="text" class="form-control" id="total" name="total" v-model="city" required>
                        </div>
                        <div class="form-group">
                            <label for="total">Postcode:</label>
                            <input type="text" class="form-control" id="total" name="total" v-model="postcode" required>
                        </div>
                        <div class="form-group">
                            <label for="total">State:</label>
                            <input type="text" class="form-control" id="total" name="total" v-model="state" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" v-text="action" @click="execute"></button>

                    </div>
                </div>
            </order-form>
        </div>
    </div>
</div>
@endsection
