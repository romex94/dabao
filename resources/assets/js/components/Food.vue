<template>
	<div :id="'food-'+data.id">
		<div class="item-summary">
			<div class="item-images">
				<slider animation="fade" :auto="false" :indicators="false">
					<slider-item v-for="(i, index) in data.medias" :key="index">
						<div class="slider-image" :style="'background-image:url('+ host + '/' +i.publicPath+');'"></div>
					</slider-item>
				</slider>
			</div>
			<div class="item-contents">
				<span class="name" v-text="data.name"></span><br>
				<span class="glyphicon glyphicon-time"></span> <span class="preparation-time" v-text="data.cooking_time"></span> minutes <!-- <span class="ratings" v-text="data.rating"></span> <span class="glyphicon glyphicon-star"></span> --><br>
				<span class="price" v-text="'RM'+data.price"></span>
				
			</div>
			<div class="buttons flex-row">
				<div class="btn-teal">view details</div>
				<div class="btn-royal-blue" v-if="data.sizes.length > 0" @click="purchase">select sizes</div>
				<div class="btn-royal-blue" v-else @click="purchase">add to cart</div>
			</div>
		</div>
		
	</div>
</template>

<script>
	import{ Slider, SliderItem } from 'vue-easy-slider';
	export default {
		props: ['data'],
		components: { Slider, SliderItem },
		data() {
			return {
				host: "http://chef.welory.com.my"
			};
		},

		computed: {
			
		},

		methods: {
			purchase() {
				this.$emit('purchase');
			}
		}	
	}
</script>