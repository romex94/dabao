<template>
	<div class="cart-container">
		<div class="cart" @click="opened = true">
			<span class="glyphicon glyphicon-shopping-cart"></span>
			Cart <span class="badge" v-text="itemsCount"></span>
		</div>
		<cart-items v-show="opened" 
					@closed="cartItemClosed" 
					:initial-cart-items="items" >
				
		</cart-items>
		
	</div>	
</template>

<script>
	import CartItems from './CartItems.vue';

	import collection from '../mixins/collection';

	export default {

		components: { CartItems },

		mixins: [collection],

		data() {
			return {
				opened : false,
			};
		},

		created() {
			this.fetch();

			window.events.$on('cart_refresh', data => {
				this.fetch();
			});
		},

		methods: {
			cartItemClosed() {
				this.opened = false;
			},

			fetch(){
				if(this.signedIn) {
					axios.get(this.url()).then(this.refresh);
				}
			},

			url(){
				return "/cart";
			},

			refresh({data}){
				this.items = [];
				var item;

				for(item in data){
					this.items.push(data[item]);
				};
			},

		},

		computed: {
			signedIn(){
				return window.Laravel.signedIn;
			},

			itemsCount(){
				var total = 0;
				var item;
				for(item in this.items){
					total = total + this.items[item].qty;
				};
				return total;
			}
		}
	}
</script>