<template>
	<input type="text" class="form-control" v-model="testValue" />
	<button @click="checkValue">Check</button>
</template>

<script>
	export default {
		data() {
			return {
				testValue: "",
			};
		},
		methods: {
			checkValue() {
				console.log(typeof this.testValue);
			},
		},
	};
</script>

<style></style>
