<template>
    <button :class="classes" @click="subscribe"><i class="far" :class=" active ? 'fa-check-square':'fa-square'"></i>
        <span v-if="active">Subscribed</span><span v-else>Subscribe</span></button>
</template>

<script>
    export default{
        props: ['active'],
        computed: {
            classes(){
                return ['btn', this.active ? 'btn-success' : 'btn-outline-success'];
            }
        },
        methods: {
            subscribe(){
                axios[(this.active ? 'delete' : 'post')](location.pathname + '/subscriptions');
                this.active = !this.active;
            }
        }
    }
</script>