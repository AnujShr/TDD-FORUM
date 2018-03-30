<template>
    <div :id="'reply-'+id" class="card" :class="isBest?'border-success':''">
        <div class="card-header" :class="isBest? 'bg-danger text-white':''">
            <div class="level">
                <h6 class="flex">
                    <a :class="isBest?'user':''" :href="'/profiles/'+reply.owner.name"
                       v-text="reply.owner.name">
                    </a> said <span v-text="ago"></span>...
                </h6>
                <div v-if="signedIn">
                    <favorites :reply="reply"></favorites>
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
                <div v-else v-html="body"></div>
            </div>
        </div>

        <div class="card-footer level" v-if="authorize('owns',reply)||authorize('owns',reply.thread)">
            <div v-if="authorize('owns',reply)">
                <button class="btn btn-primary btn-xs mr-1" @click="editing = true">Edit</button>
                <button class="btn btn-outline-danger btn-xs mr-1" @click="destroy">DELETE</button>
            </div>
            <button class="btn btn-outline-success ml-a" @click="markBestReply" v-show="!isBest"
                    v-if="authorize('owns',reply.thread)">Best Reply
            </button>
        </div>

    </div>
</template>

<script>
    import Favorites from './FavoriteComponent.vue';
    import moment from 'moment';
    export default{
        props: ['reply'],
        components: {Favorites},
        data(){
            return {
                editing: false,
                id: this.reply.id,
                body: this.reply.body,
                isBest: this.reply.isBest
            };
        },
        computed: {
            ago(){
                return moment(this.reply.created_at).fromNow();
            }
        },
        created(){
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
        },
        methods: {
            update(){
                axios.patch('/replies/' + this.id, {
                    body: this.body
                }).catch(error => {
                    flash(error.response.data, 'danger')
                });
                this.editing = false;
                flash('Updated!');
            },
            destroy(){
                axios.delete('/replies/' + this.id);
                this.$emit('deleted', this.id);
//                $(this.$el).fadeOut(300, () => {
//                    flash('Your reply has been deleted');
//                });
            },
            markBestReply(){
                axios.post('/replies/' + this.id + '/best');
                window.events.$emit('best-reply-selected', this.id)
            }
        }
    }

</script>


