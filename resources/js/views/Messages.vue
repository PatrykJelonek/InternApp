<template>
    <v-container fluid >
        <v-row>
            <v-col>
                <messages-list></messages-list>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import MessagesList from "../components/Messages/MessagesList";
export default {
    name: "Messages",
    components: {MessagesList}
}
</script>

<style scoped>

</style>
