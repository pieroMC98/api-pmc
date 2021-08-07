<template>
	<div>
		<h1>Prueba de props y eventos</h1>
		<table-component></table-component>
	</div>
</template>

<script charset="utf-8">
import tableComponent from './table.vue'
export default {
	components: {
		tableComponent,
	},
	data() {
		return {}
	},
}
</script>
