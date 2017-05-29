<script>
	export default {
		props: [
			'attributes'
		],
		data() {
			return {
				editing: false,
				favoritesCount: this.attributes.favorites.length,
				body: this.attributes.body
			};
		},

		methods: {
			favorite() {
				axios.post('/replies/' + this.attributes.id + '/favorites');
				this.favoritesCount ++;
				flash('Reply favorited!');
			},
			update() {
				axios.patch('/replies/' + this.attributes.id, {
					body: this.body
				});
				this.editing = false;
				flash('Reply updated!');
			},
			destroy() {
				axios.delete('/replies/' + this.attributes.id);
				$(this.$el).fadeOut(300, () => {
					flash('Reply deleted.');
				});
			},
			toggleEditing() {
				this.editing = ! this.editing
			}
		}
	}
</script>