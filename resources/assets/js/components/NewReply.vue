<template>
    <div>
        <div v-if="signedIn">
            <br>
            <div class="form-group">
            <textarea name="body" id="body" class="form-control" rows="10"
                      placeholder="Has Something to Say?" v-model="body" required></textarea>
            </div>

            <button type="submit" class="btn btn-outline-dark btn-lg btn-block" @click="addReply">REPLY</button>
        </div>
        <p class="text-center" v-else>Please <a href="/login">Sign in</a> to reply.</p>

    </div>
</template>
<script>
    import 'at.js';
    import 'jquery.caret';
    export default{
        data(){
            return {
                body: '',
            }
        },
        mounted(){
            $('#body').atwho({
                at: '@',
                delay: 750,
                callbacks: {
                    remoteFilter: function (query, callback) {
                        $.getJSON("/api/users", {name: query}, function (usernames) {
                            callback(usernames)
                        });
                    }
                }
            });
        },
        methods: {
            addReply(){
                axios.post(location.pathname + '/replies', {body: this.body})
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    }).then(({data}) => {
                    this.body = '';

                    flash('Your reply has been posted');
                    this.$emit('created', data);
                })

            }
        }
    }
</script>