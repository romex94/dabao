<template>
	<div>
		<div class="grid-layout">
			<food class="grid-items" v-for="(item, index) in items" :data="item" :key="index" @purchase="purchase(item)"></food>
		</div>	
		<transition name="slide-fade">
			<div class="modal fade in" tabindex="-1" role="dialog" v-if="is_purchasing" id="option_modal"> 
			  	<div class="modal-dialog" role="document">
			    	<div class="modal-content">
				      	<div class="modal-header">
				        	<button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close_modal"><span aria-hidden="true">&times;</span></button>
				        	<h4 class="modal-title">Select options</h4>
				      	</div>
				      	<div class="modal-body">
				      		<div class="flex-row flex-row-center">
					      		<div>Size:</div>
					      		<div class="space-15px"></div>
					      		<div class="flex">
						        	<select v-model="size" class="form-control">
										<option v-for="(size, index) in purchasing_food.sizes" :value="size"><span class="text-capitalize" v-text="size.size"></span> - RM{{ size.price }}</option>
						        	</select>
					        	</div>
				        	</div>
				      	</div>
				      	<div class="modal-footer">
				        	<button type="button" class="btn btn-default" data-dismiss="modal" @click="close_modal">Close</button>
				        	<button type="button" class="btn btn-primary" @click="confirm_purchase">Add to cart</button>
				      	</div>
			    	</div><!-- /.modal-content -->
			  	</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		</transition>
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
				host: "http://chef.welory.com.my",
				is_purchasing: false,
				purchasing_food: false,
				size: false

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
				//console.log(data);
			},

			purchase(food) {
				//console.log(food);
				
				this.purchasing_food = food;
				

				if(food.sizes.length == 0) 
				{
					// This food doesn't have any size
					this.size = { 
						price: this.purchasing_food.price,
						size: "default"
					};
					this.confirm_purchase();

				}
				else this.is_purchasing = true;
			},

			confirm_purchase() {
				axios.post("/cart/add", {
					name: this.purchasing_food.name,
					price: this.size.price,
					description: this.size.size,
					type: "food",
					type_id: this.purchasing_food.id,
					quantity: 1,	
					photo: this.host + '/' + this.purchasing_food.medias[0].publicPath 
				});
				this.is_purchasing = false;

				cart_refresh();

				flash('Added item to cart!');
				
			},

			close_modal() {
				this.is_purchasing = false;
				this.purchasing_food = false;
				this.size = false;
			}
		}
	}
</script>