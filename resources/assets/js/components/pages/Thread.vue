<script>
    import Replies from '../Replies.vue'
    import SubscribeButton from '../SubscribeButton.vue';
    export default{
        props: ['initialRepliesCount'],
        components: {Replies,SubscribeButton},
        data(){
            return {
                repliesCount: this.initialRepliesCount,
            }
        }
    }
</script>