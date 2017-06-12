<template>
	
</template>

<script>
	import moment from 'moment';
	export default {
		data() {
			return {
				delivery_time: moment().format("MM-DD-YYYY hh:mm"),
				total: 0,
				driver_id: 0,
				delivery_location: "Somewhere in the forest",
				action: "Search driver",
				is_loading: false
			};
		},

		methods: {
			execute() {
				if( this.action == "Search driver" )
				{
					
					this.is_loading = true;
					// Post a request to Driver app to search driver
					// On success, create an order
					 
				}
			}
		}

	}
</script>