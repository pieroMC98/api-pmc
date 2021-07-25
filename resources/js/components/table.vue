<template>
	<div>
		<h2>Tabla de ejemplo</h2>
		<b-form-select
			@change="setSelect"
			v-model="selected"
			:options="options"
		></b-form-select>
		<hr />
		<b-form-input
			v-model="question"
			type="number"
			placeholder="campo"
		></b-form-input>
		<hr />
		<span>{{ answer }}</span>
		<hr />
		<span>el link es : {{ link }}</span>
		<div>
			<b-table striped hover :items="response"></b-table>
		</div>
	</div>
</template>

<script>
import { isEmpty, isNumber } from 'lodash'
export default {
	data() {
		return {
			campo: '',
			answer: null,
			question: '',
			response: [],
			options: ['user', 'product', 'transaction'],
			selected: 'product',
			set: '',
		}
	},
	watch: {
		// cada vez que la pregunta cambie, esta función será ejecutada
		question: function (newQuestion, oldQuestion) {
			this.answer = 'Esperando que deje de escribir...'
			this.debouncedGetAnswer()
		},
	},
	created: function () {
		// _.debounce es una función proporcionada por lodash para limitar cuan
		// a menudo se puede ejecutar una operación particularmente costosa.
		// En este caso, queremos limitar la frecuencia con la que accedemos a
		// yesno.wtf/api, esperando hasta que el usuario haya terminado
		// de escribir antes de realizar la solicitud ajax.
		// Para aprender más sobre la función _.debounce (y su primo
		// _.throttle), visite: https://lodash.com/docs#debounce
		axios
			// .get('http://127.0.0.1:8000/api/product')
			.get('http://127.0.0.1:8000/api/' + this.selected)
			.then((aux) => (this.response = aux.data.data))
			.catch((error) => console.log(error))
		this.debouncedGetAnswer = _.debounce(this.getAnswer, 500)
	},
	computed: {
		link: function () {
			return (
				'http://127.0.0.1:8000/api/' +
				this.selected +
				'/' +
				this.question
			)
		},
	},
	methods: {
		setSelect: function (select) {
			this.set = select
		},
		getAnswer: function () {
			this.answer = 'modelo es: ' + this.set
			this.response = []
			if (isEmpty(this.question))
				axios
					// .get(this.link)
					// .get('http://127.0.0.1:8000/api/' + this.selected)
					.get('http://127.0.0.1:8000/api/product/')
					.then((rt) => (this.response = rt.data.data))
					.catch(function (error) {
						this.answer =
							'¡Error! No se pudo alcanzar la API. ' + error
					})
			else
				axios
					.get(this.link)
					// .get( 'http://127.0.0.1:8000/api/' + this.selected + '/' + this.question)
					.then((rt) => this.response.push(rt.data.data))
					.catch(function (error) {
						this.answer =
							'¡Error! No se pudo alcanzar la API. ' + error
					})
		},
	},
}
</script>
