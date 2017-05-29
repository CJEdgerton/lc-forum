<template>
	<button class="btn btn-default btn-sm pull-right" @click="toggle">
		<span  v-bind:class="{ 'text-primary': isFavoritedByCurrentUser }">
		<span class="glyphicon glyphicon-thumbs-up"></span> {{ favoritesCount }} 
		</span>
	</button>
</template>

<script>
	export default {
		props: [
			'reply'
		],
		data() {
			return {
				favoritesCount: this.reply.favoritesCount,
				isFavoritedByCurrentUser: this.reply.isFavoritedByCurrentUser,  
			};
		},
		computed: {
			endpoint() {
				return '/replies/' + this.reply.id + '/favorites';
			}
		},
		methods: {
			toggle() {
				this.isFavoritedByCurrentUser ? this.destroy() : this.create();
			},
			destroy() {
				axios.delete(this.endpoint);
				this.isFavoritedByCurrentUser = false;
				this.favoritesCount --;
			},
			create() {
				axios.post(this.endpoint);
				this.isFavoritedByCurrentUser = true;
				this.favoritesCount ++;
			}
		}
	}
</script>