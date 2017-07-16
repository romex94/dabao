<script>
	import moment from 'moment';
	import swal from 'sweetalert2';
	import AddressSelector from './AddressSelector.vue';

	var globaldata;
	export default {
		components: { AddressSelector },

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
		        status: "Loading",
		        address: 0,
		        selected_address: 999
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
			createOrder() {
				// Create an empty order first
				axios.post('/order', {
					delivery_location: this.fullAddress,
					delivery_time: this.delivery_time,
					latitude: this.marker_position.lat,
					longitude: this.marker_position.lng,
					address_id: this.selected_address,
					address_line_1: this.unit,
					address_line_2: this.route,
					town: this.city,
					state: this.state,
					postcode: this.postcode
				})
				.then(({data}) => {
					// After creating order, post to find a driver
					this.findDriver(data);
					//this.order_id = data.id;
					//console.log(data);
					
				});
			},

			findDriver(data) {
				this.order_id = data.id;
				axios.post('http://driver.welory.com.my/api/find/driver', {
					latitude: this.marker_position.lat,
					longitude: this.marker_position.lng,
					address: this.fullAddress,
					time: this.delivery_time,
					order_id : data.id
				})
				.then(({data}) => {
					this.status = "Finding driver";
					this.listen();	
					
				});
			},
			listen(){
				// Listen to driver result Pusher event
				Echo.channel('order-id-' + this.order_id)
				    .listen('DriverResultReturned', (e) => {
				    	var alerttext = "Driver not found, please try again";
				    	if(e.status == "found")
				    	{
				    		alerttext = e.driver_name + " will be delivering your food.";
				    	}
				        swal({
						  	title: 'Driver status: ' + e.status + 'Click the button below to start shopping! <br><small>You will be redirected in 5 seconds</small>',
						  	text: alerttext,
						  	type: 'info',
						  	timer: 5000,
						  	confirmButtonText: "Select chef"
						  	// TODO Add driver image
						}).then(
							function() {
								window.location = "/chefs";
							},
							function (dismiss) {
								if(dismiss === 'timer') {
									window.location = "/chefs";
								}
							}
						);
						this.Loading = false;
						if( e.status == "found" )
						{
							// Redirect to select chef page
							
							console.log("Redirecting to select chef");
						}
						
				    });
				    // Test posting to the API
					axios.post('/api/driver/result', {
						driver_name: "Cibai Haw",
						driver_id: "1",
						driver_image: "some-url",
						status: "found",
						order_id: this.order_id
					});
			},
			execute() {
				if( this.action == "Search driver" )
				{
					
					this.is_loading = true;
					this.status = "Sending request";
					this.createOrder();
				}
			},

			updateCenter(newCenter) {
				this.map_center = {
					lat: newCenter.lat(),
					lng: newCenter.lng(),
				}
			},
			updateMarkerCenter(data) {
				//console.log(data);
				this.marker_position = data.latLng;
				//console.log(this.marker_position.lat);
				this.location_type = "Custom location";
				this.delivery_location = this.marker_position.lat + " " + this.marker_position.lng;
				//console.log(this.delivery_location);
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

			updateAddress(data) {
				//console.log(data);
				this.unit = data.address_line_1;
				this.route = data.address_line_2;
				this.city = data.town;
				this.state = data.state;
				this.postcode = data.postcode;
				var coordinate = {lat: data.latitude, lng: data.longitude};
				this.map_center = coordinate;
				this.marker_position = coordinate;
				this.selected_address = data.id;
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