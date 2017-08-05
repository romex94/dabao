<template>
	<div class="cart-items">
		<span class="glyphicon glyphicon-remove" @click="close"></span>

		<div v-if="signedIn">
			<div v-if="initialCartItems.length">
				<ul class="list-group">
					<cart-item v-for="(item, index) in initialCartItems" :key="item.id" :data="item" :sequence="index" @reduced="reduce"></cart-item>
					<li class="list-group-item cart-info">
						<div class="flex-row">
							<div class="flex">Subtotal: RM<span v-text="subtotal"></span></div>
							<button class="btn btn-primary">Checkout</button>
						</div>
					</li>
				</ul>
			</div>
			<div v-else>
				<ul class="list-group">
					<li class="list-group-item">There are no items in your cart</li>
				</ul>
			</div>
		</div>
		<div v-else>
			<ul class="list-group">
				<li class="list-group-item">Please <a href="/login">sign in</a> to use the cart</li>
			</ul>
		</div>
	</div>
</template>

<script>
	import CartItem from './CartItem.vue';

	export default {
		props: ['initialCartItems'],
		components: { CartItem },
		data() {
			return {

			};
		},

		methods: {
			close() {
				this.$emit('closed');
			},

			reduce(index) {
				cart_refresh();
			}	
		},

		computed: {
			signedIn(){
				return window.Laravel.signedIn;
			},
			subtotal(){
				var total = 0;
				var item;
				for( item in this.initialCartItems ){
					total += this.initialCartItems[item].subtotal * this.initialCartItems[item].qty;
				}
				return total.toFixed(2);
			}
		}	
	}
</script>