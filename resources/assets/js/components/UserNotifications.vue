<template>
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             Notification <span class="caret"></span>
        </a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown" v-if="notifications.length">
            <div v-for="notification in notifications" >
                <a class="dropdown-item" :href="notification.data.link" v-text="notification.data.message">
                </a>
            </div>
        </div>
    </li>
</template>
<script>
    export default{
        data(){
            return {
                notifications: false
            }
        },
        created(){
            axios.get("/profiles/'" + window.App.user.name + "/notifications")
                .then(response => this.notifications = response.data);
        }
    }
</script>