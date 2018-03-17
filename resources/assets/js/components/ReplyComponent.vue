<template>
    <div :id="'reply-'+id" class="card">
        <div class="card-header">
            <div class="level">
                <h6 class="flex">
                    <a :href="'/profiles/'+data.owner.name"
                       v-text="data.owner.name">
                    </a> said <span v-text="ago"></span>...
                </h6>
                <div v-if="signedIn">
                    <favorites :reply="data"></favorites>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="body">
                <div v-if="editing">
                    <form @submit="update">
                        <div class="form-group">
                            <textarea class="form-control" v-model="body" required></textarea>
                        </div>
                        <button class="btn btn-sm btn-primary">Update</button>
                        <button class="btn btn-sm btn-link-" @click="editing = false" type="button">Cancel</button>
                </form>
                </div>
                <div v-else v-text="body"></div>
            </div>
        </div>

        <div class="card-footer level" v-if="canUpdate">
            <button class="btn btn-outline-info btn-xs mr-1" @click="editing = true">Edit</button>
            <button class="btn btn-outline-danger btn-xs mr-1" @click="destroy">DELETE</button>
        </div>

    </div>
</template>

<script>
    import Favorites from './FavoriteComponent.vue'
    import moment from 'moment';
    export default{
        props: ['data'],
        components: {Favorites},
        data(){
            return {
                editing: false,
                id: this.data.id,
                body: this.data.body
            };
        },
        computed: {
            signedIn(){
                return window.App.signedIn;
            },
            canUpdate(){
                return this.authorize(user => this.data.user_id == user.id);
            },
            ago(){
                return moment(this.data.created_at).fromNow();
            }
        },
        methods: {
            update(){
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                }).catch(error => {
                    flash(error.response.data, 'danger')
                });
                this.editing = false;
                flash('Updated!');
            },
            destroy(){
                axios.delete('/replies/' + this.data.id);
                this.$emit('deleted', this.data.id);
//                $(this.$el).fadeOut(300, () => {
//                    flash('Your reply has been deleted');
//                });
            }
        }
    }

</script>


