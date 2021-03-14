<template>
    <v-list-item
        link
        dense
        @click="cardOnClick"
        class="py-0"
    >
        <v-list-item-avatar
            :color="$route.params.studentIndex === index ? 'success' : 'grey darken-4'"
            rounded
            size="30"
        >
            {{ firstname[0] + '' + lastname[0] }}
        </v-list-item-avatar>
        <v-list-item-content>
            <v-list-item-title> {{ firstname + ' ' + lastname }}</v-list-item-title>
            <v-list-item-subtitle>{{ index }}</v-list-item-subtitle>
        </v-list-item-content>
        <v-list-item-action>
            <v-btn icon>
                <v-icon color="grey lighten-1">mdi-information</v-icon>
            </v-btn>
        </v-list-item-action>
    </v-list-item>
</template>

<script>
import router from "../../router/routers";

export default {
    name: "TheInternshipStudentsDrawerItem",
    props: ['firstname', 'lastname', 'index'],
    data() {
        return {
            color: 'primary'
        }
    },
    methods: {
        cardOnClick() {
            router.push({name: 'internship-student', params: {studentIndex: this.index}});
            this.color = 'success';
        },
    }
}
</script>

<style scoped>

</style>
