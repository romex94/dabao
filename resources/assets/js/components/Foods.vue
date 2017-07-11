<template>
	<div class="grid-layout">
		<food class="grid-items" v-for="(item, index) in items" :data="item" :key="index"></food>
	</div>	
</template>

<script>
	import Food from './Food.vue';

	import collection from '../mixins/collection';

	export default {
		props: ['chef'],

		mixins: [collection],

		components: { Food },
		data() {
			return {
				host: "http://chef.welory.com.my"
			};
		},

		created() {
			this.fetch();
		},	

		methods: {
			fetch() {
				axios.get(this.url()).then(this.refresh);
				this.refresh([]);
			},

			url() {
				return this.host + "/api/chef/foodlist/" + this.chef;
			},

			refresh(data) {
				
				this.items = data.data;
				console.log(data);
			}
		}
	}
</script>