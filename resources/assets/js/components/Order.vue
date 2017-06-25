<template>
	
</template>

<script>
	import moment from 'moment';

	export default {
		data() {
			return {
				delivery_time: moment().add(1, 'hours').format("YYYY-MM-DD hh:mm"),
				total: 0,
				driver_id: 0,
				delivery_location: "Current location",
				location_type: "Current location",
				action: "Search driver",
				is_loading: false,
				map_center: {lat: 0, lng: 0},
				marker_position: {lat: 0, lng: 0},
				zoom: 17,
				place: null,
				infoWinOpen: false,
				infoOptions: {
		            pixelOffset: {
		              	width: 0,
		              	height: -35
		            }
		        },	
		        infoWindowPos: {lat: 0, lng: 0},
		        route: "",
		        postcode: "",
		        state: "",
		        city: "",
		        unit: "",
		        order_id: 0,
		        status: "Loading"
			}
		},

		computed: {
			infoContent() {
				return "<b>" + this.location_type +"</b>" + "<br>" + this.delivery_location;			
			},
			fullAddress() {
				return this.unit + ", " + this.route + ", " + this.city + ", " + this.postcode + ", " + this.state;
			}
		},

		mounted() {
			this.is_loading = true;
			if ('geolocation' in navigator) {
		        var gl = navigator.geolocation;
		        gl.getCurrentPosition(function(position) {
		          	this.map_center.lat = position.coords.latitude;
		          	this.map_center.lng = position.coords.longitude;
		          	this.marker_position.lat = position.coords.latitude;
		          	this.marker_position.lng = position.coords.longitude;
		        }.bind(this));
		        this.is_loading = false;
		    }	
		},

		methods: {
			execute() {
				if( this.action == "Search driver" )
				{
					
					this.is_loading = true;
					this.status = "Sending request";
					// Create an empty order first
					axios.post('/order', {
						delivery_location: this.fullAddress,
						delivery_time: this.delivery_time,
						latitude: this.marker_position.lat,
						longitude: this.marker_position.lng
					})
					.then(({data}) => {
						// After creating order, post to find a driver
						
						this.order_id = data.id;
						axios.post('http://driver.welory.com.my/api/find/driver', {
							latitude: this.marker_position.lat,
							longitude: this.marker_position.lng,
							address: this.fullAddress,
							time: this.delivery_time,
							order_id : data.id
						})
						.then(({data}) => {
							console.log(data);
							this.status = "Finding driver";
						});
					 
					});
					
				}
			},
			updateCenter(newCenter) {
				this.map_center = {
					lat: newCenter.lat(),
					lng: newCenter.lng(),
				}
			},
			updateMarkerCenter() {

				marker_position = this.$refs.markdelivery.position;
				this.location_type = "Custom location";
				this.delivery_location = marker_position.lat + " " + marker_position.lng;
				this.address = "";

			},
			setPlace(place) {
				this.$refs.markdelivery.position.lat = place.geometry.location.lat();
				this.$refs.markdelivery.position.lng = place.geometry.location.lng();
				this.updateCenter(place.geometry.location);
				this.location_type = "Found place";
				this.delivery_location = place.adr_address;
				this.updateAddressForm(place);

			},
			toggleInfoWindow() {
				this.infoWindowPos = this.marker_position;
				this.infoContent = this.delivery_location;

				this.infoWinOpen = !this.infoWinOpen;	
			},

			updateAddressForm(place) {
				for(var i = 0; i < place.address_components.length; i++)
				{
					var component = place.address_components[i]
					for(var j = 0; j < component.types.length; j++)
					{

						var type = place.address_components[i].types[j];
						if(type == 'route')
						{
							this.route = component.long_name;
						}
						if(type == 'postal_code')
						{
							this.postcode = component.long_name;
						}
						if(type == 'locality')
						{
							this.city = component.long_name;
						}
						if(type == 'street_number')
						{
							this.unit = component.long_name;
						}
						if(type == 'administrative_area_level_1')
						{
							this.state = component.long_name;
						}
					}
				}

			}

		}
	}
</script>