<script>
	export default {
		props: [
			'attributes'
		],
		data() {
			return {
				editing: false,
				body: this.attributes.body
			};
		},

		methods: {
			update() {
				axios.patch('/replies/' + this.attributes.id, {
					body: this.body
				});
				this.editing = false;
				flash('Reply updated!');
			},
			toggleEditing() {
				this.editing = ! this.editing
			}
		},
		computed: {
			classForEditingButton: function () {
				return {
					'text-success': this.editing,
				}
			}
		}
	}
</script>