<template>
    <button type="submit" :class="classes" @click="toggle">
        <i class="fas fa-heart"></i>
        <span class="glypicon glpicon-heart"></span>
        <span v-text="count"></span>
    </button>
</template>

<script>
    export default {
        props: ['reply'],

        data() {
            return {
                count: this.reply.favoritesCount,
                active: this.reply.isFavorited,
            }
        },

        computed: {
            classes() {
                return ['btn', this.active ? 'btn-primary' : 'btn-default'];
            }
        },

        methods: {
            toggle() {
                (this.active) ? this.destroy() : this.liked();
            },
            liked(){
                axios.post('/replies/' + this.reply.id + '/favorites');
                this.active = true;
                this.count++;
            },
            destroy(){
                axios.delete('/replies/' + this.reply.id + '/favorites');
                this.active = false;
                this.count--
            }
        }
    }
</script>