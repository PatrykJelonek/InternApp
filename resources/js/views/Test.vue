<template>
    <v-app>
        <h1>Test</h1>
        <pusher-test></pusher-test>
    </v-app>
</template>

<script>
import PusherTest from "./PusherTest";
export default {
    name: "Test",
    components: {PusherTest},
    data() {
        return {
            items: [
                {title: 'Home', icon: 'mdi-view-dashboard'},
                {title: 'About', icon: 'mdi-forum'},
            ],
            links: ['Home', 'Contacts', 'Settings'],
            mini: true,
        }
    },
}
</script>

<style scoped>

</style>
