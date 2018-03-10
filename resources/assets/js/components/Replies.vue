<template>
    <div>
        <div v-for="(reply,index) in items" :key="reply.id">
            <br>
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>
         <paginator :dataSet="dataSet" @changed="fetch"></paginator>
        <new-reply @created="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './ReplyComponent.vue';
    import NewReply from './NewReply.vue';
    import collection from './mixins/Collection.js';
    export default{
        components: {Reply, NewReply},
        mixins: [collection],
        data(){
            return {
                dataSet: false
            }
        },
        created(){
            this.fetch();
        },
        methods: {
            fetch(page){
                axios.get(this.url(page))
                    .then(this.refresh);
            },
            url(page){
                if(!page){
                    let query = location.search.match('/page=(\d+)/');
                    page = query ? query[1] : 1
                }
                return `${location.pathname}/replies?page=${page}`;
            },
            refresh({data}){
//                console.log(response)
                this.dataSet = data;
                this.items = data.data;
            }
        }
    }
</script>