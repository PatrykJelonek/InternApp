<template>
    <v-card
        color="cardBackground"
        elevation="0"
        class="mb-3"
        @click="setPreview(content)"
    >
        <v-list flat two-line color="transparent">
            <v-list-item-group multiple>
                <v-list-item :ripple="false">
                    <v-list-item-content>
                        <v-list-item-title class="text-m font-weight-bold">
                            Dzień
                        </v-list-item-title>
                        <v-list-item-subtitle class="text-m">123</v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-action>
                        <v-menu bottom left nudge-left="30px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-icon
                                    v-bind="attrs"
                                    v-on="on"
                                >mdi-dots-vertical
                                </v-icon>
                            </template>
                            <v-list>
                                <v-list-item>
                                    <v-list-item-title>Edytuj wpis</v-list-item-title>
                                </v-list-item>
                                <v-list-item>
                                    <v-list-item-title>Usuń wpis</v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </v-list-item-action>
                </v-list-item>
            </v-list-item-group>
        </v-list>
    </v-card>
</template>

<script>
    import {mapActions} from "vuex";

    export default {
        name: "JournalEntrySmallCard",
        props: ['content'],


        data() {
            return {

            }
        },

        methods: {
            ...mapActions({
                setPreview: 'internship/setPreview',
            }),

            // getInternshipDay: (internshipStartDate, journalEntryDate) => {
            //     return moment(journalEntryDate).diff(moment(internshipStartDate), 'days') + 1;
            // },
            // formatDate(date, format) {
            //     return moment(date).format(format);
            // },
        },

        created() {
        }
    }
</script>

<style scoped>

</style>
