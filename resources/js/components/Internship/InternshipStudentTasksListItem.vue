<template>
    <v-card
        color="cardBackground"
        elevation="0"
        class="mb-3"
        @click="cardOnClick"
    >
        <v-list flat two-line color="transparent">
            <v-list-item-group multiple>
                <v-list-item :ripple="false">
                    <v-list-item-content>
                        <v-list-item-title class="text-m font-weight-bold">{{name}}</v-list-item-title>
                        <v-list-item-subtitle>{{description}}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-list-item-group>
        </v-list>
        <v-dialog
            v-model="dialog"
            max-width="600px"
            class="mx-10"
        >
            <v-card
                class="pa-1"
                color="cardBackground"
            >
                <v-card-title>{{name}}</v-card-title>
                <v-card-subtitle>Niewykonany</v-card-subtitle>
                <v-card-text>{{description}}</v-card-text>
            </v-card>
        </v-dialog>
    </v-card>
</template>

<script>
    import {mapActions} from "vuex";

    export default {
        name: "InternshipStudentTasksListItem",
        props: ['name', 'description'],

        data() {
            return {
                dialog: false,
            }
        },

        methods: {
            ...mapActions({
                setPreview: 'internship/setPreview'
            }),

            cardOnClick() {
                if(this.$vuetify.breakpoint.lgAndUp) {
                    this.setPreview(this.description);
                } else {
                    this.dialog = !this.dialog;
                }
            }
        },
    }
</script>

<style scoped>

</style>
