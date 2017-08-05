<template>
	<div class="form-group">
		<select class="form-control" @change="changeAddress" v-model="selected">
			<option disabled value="999">Select an address from previous orders</option>
			<option v-for="(item, index) in addresses" :key="index" v-text="item.fullAddress" :value="index"></option>
		</select>
	</div>
</template>

<script>
	export default {
		props: ['addresses'],

		data() {
			return {
				selected: 999
			};
		},

		methods: {
			changeAddress() {
				this.$emit("address_changed", this.addresses[this.selected]);
			}
		}	

	}
</script>