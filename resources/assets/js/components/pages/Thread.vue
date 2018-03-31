<script>
    import Replies from '../Replies.vue'
    import SubscribeButton from '../SubscribeButton.vue';
    export default{
        props: ['thread'],
        components: {Replies, SubscribeButton},
        data(){
            return {
                repliesCount: this.thread.replies_count,
                locked: this.thread.locked
            }
        },
        methods: {
            togglelock(){
                axios[this.locked ? 'delete' : 'post']('/locked-thread/' + this.thread.slug);
                this.locked = ! this.locked;

            }
        }
    }
</script>