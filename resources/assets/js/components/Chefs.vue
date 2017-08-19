<template>
	<div class="grid-layout">
		<chef class="grid-items" v-for="(item, index) in items" :data="item" :key="index"></chef>
	</div>
</template>

<script>
	import Chef from './Chef.vue';
	import collection from '../mixins/collection';
	export default {
		props: ['order', 'halal'],
		components: { Chef },

		mixins: [collection],

		data() {
			return {
				dataSet: false,
				host: "https://chef.welory.com.my"
			}
		},

		created() {
			this.fetch();
		},

		methods: {
			fetch(page) {
				// Send a get request to chef app to get chefs
				//console.log(this.order);
				axios.get(this.url(page),{
					params: {
						delivery_datetime: this.order.delivery_time,
						postcode: this.order.address.postcode,
						is_halal: this.halal
					}
				}).then(this.refresh);
			},

			url(page) {
				if(!page) {
					let query = location.search.match(/page=(\d+)/);
					page = query ? query[1] : 1;
				}
				return `${this.host}/api/cheflist?page=${page}`;
			},
			refresh({data}) {
				this.dataSet = data;
				this.items = data;

				window.scrollTo(0,0);
			}
		}	
	}
</script>