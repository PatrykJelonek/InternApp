<template>
    <div>
        <chat-message
        message="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad atque blanditiis dolor, dolorum earum, explicabo harum illo, ipsum iure officia placeat porro quae quo suscipit tenetur unde vero! Dolore, laborum?"
        user-full-name="Patryk Jelonek"
        user-id="1"
        date="2021-01-01"
        ></chat-message>
        <chat-message
            message="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad atque blanditiis dolor, dolorum earum, explicabo harum illo, ipsum iure officia placeat porro quae quo suscipit tenetur unde vero! Dolore, laborum?"
            user-full-name="Patryk Jelonek"
            user-id="1"
            date="2021-01-01"
            self="true"
        ></chat-message>
    </div>
</template>

<script>
import PusherTest from "../../../views/PusherTest";
import ChatMessage from "../../Chat/ChatMessage";
export default {
    name: "TheAdminTest",
    components: {ChatMessage, PusherTest}
}
</script>

<style scoped>

</style>
