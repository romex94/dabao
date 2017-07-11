<template>
	<li :id="'item-'+id" :class="'list-group-item cart-item ' + data.options.type">
		<div class="flex-row">
			<img :src="data.options.photo" width="80px" height="80px"/>
			<div class="flex">
				<span class="name" v-text="name"></span><br>
				<span class="quantity" v-text="'Quantity: ' + quantity"></span><br>
				<span class="price" v-text="'RM' + subtotal"></span>
			</div>
			<span class="glyphicon glyphicon-minus" @click="requestReduce"></span>
		</div>
	</li>
</template>

<script>
	export default {
		props: ['data', 'sequence'],
		data() {
			return {
				key: this.data.rowId,
				id: this.data.id,
				name: this.data.name,
				quantity: this.data.qty
			};
		},

		methods: {
			requestReduce() {
				// Post a request to remove cart item
				axios.post("/cart/remove", {
					'rowId': this.key,
					'quantity': --this.quantity
				}).then(this.reduce);
			},

			reduce() {
				this.$emit('reduced', this.sequence);
			}
		},

		computed: {
			subtotal() {
				return this.data.subtotal * this.quantity;
			}
		}
		
	}
</script>