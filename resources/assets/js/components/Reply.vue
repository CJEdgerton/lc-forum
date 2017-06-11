<template>
<div :id="'reply-'+id" class="panel panel-default">
    <div class="panel-heading">
		<div class="level">
			<h5 class="flex">
				<a :href="'/profiles/'+data.owner.name">
					{{ data.owner.name }}
				</a> said {{ data.created_at }} ...
			</h5>
			<div>
			
				<span v-if="canUpdate">
					<button class="btn btn-sm btn-default pull-left" style="margin-right: 5px;" @click="toggleEditing">
						<span class="glyphicon glyphicon-edit" v-bind:class="{ 'text-success': editing }"></span>
					</button>
				</span>

				<span v-if="signedIn">	
					<favorite :reply="data"></favorite>	
				</span>
			</div>
		</div>
	</div>	

    <div class="panel-body">
    	<div v-if="editing">
    		<div class="form-group">
	    		<textarea v-model="body" class="form-control" rows="3"></textarea>		
    		</div>

    		<button class="btn btn-sm btn-default" @click="update">Update</button>
    		<button class="btn btn-sm btn-default" @click="editing = false">Cancel</button>

			<!-- @can('update', $reply ) -->
				<button class="btn btn-default btn-sm pull-right" @click="destroy">
					<span class="glyphicon glyphicon-trash text-danger"></span>
				</button>
			<!-- @endcan -->

    	</div>
    	<div v-else v-text="body"></div>
    </div>
</div>
</template>

<script>
	import Favorite from './Favorite.vue';

	export default {
		props: [
			'data'
		],
		components: { Favorite },
		data() {
			return {
				editing: false,
				id: this.data.id,
				body: this.data.body
			};
		},
		computed: {
			signedIn() {
				return window.App.signedIn;
			},
			canUpdate() {
				return this.authorize(user => this.data.user_id == user.id);
				return this.data.user_id == window.App.user.id;
			}
		},
		methods: {
			update() {
				axios.patch('/replies/' + this.data.id, {
					body: this.body
				});
				this.editing = false;
				flash('Reply updated!');
			},
			destroy() {
				axios.delete('/replies/' + this.data.id);
				this.$emit('deleted', this.data.id);
			},
			toggleEditing() {
				this.editing = ! this.editing
			}
		}
	}
</script>