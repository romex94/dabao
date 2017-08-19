<template>
	<div :id="'chef-'+data.id">
		<div class="item-summary">
			<div class="item-images">
				<slider animation="fade" :auto="false" :indicators="false">
					<slider-item>
						<div class="slider-image" :style="'background-image:url(' + host + '/' + data.profileImage + ');'"></div>
					</slider-item>
					<slider-item v-for="(i, index) in data.medias" :key="index" v-if="i.type=='kitchen_image'">
						<div class="slider-image" :style="'background-image:url('+ host + '/' + i.publicPath + ');'"></div>
					</slider-item>
				</slider>
			</div>
			<div class="item-contents">
				<span class="name" v-text="data.user.name"></span><br>
				<!-- <span class="ratings" v-text="data.rating"></span> <span class="glyphicon glyphicon-star"></span><br> -->
				
			</div>
			<div class="buttons flex-row">
				<a :href="'/food/' + data.id 
						+ '?name=' + data.user.name 
						+ '&address=' + data.address_line_1 + ' ,' + data.address_line_2 + ' ,' + data.town + ' ,' + data.state + ' ,' + data.postcode
						+ '&longitude=' + data.longitude 
						+ '&latitude=' + data.latitude" class="btn-teal flex">View details</a>
			</div>
		</div>
		
	</div>
</template>

<script>
	import{ Slider, SliderItem } from 'vue-easy-slider';
	export default {
		props: ['data'],
		components: {Slider, SliderItem},
		data() {
			return {
				id: this.data.id,
				host: "http://chef.welory.com.my"
			};
		}	
	}
</script>