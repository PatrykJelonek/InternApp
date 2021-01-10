<template>
    <v-container fluid >
        <h2>Welcome to the dashboard</h2>

        <vuex-tabs-items>
            <v-tab-item>
                <v-card flat>
                    <v-card-text>1</v-card-text>
                </v-card>
            </v-tab-item>
            <v-tab-item>
                <v-card flat>
                    <v-card-text>2</v-card-text>
                </v-card>
            </v-tab-item>
            <v-tab-item>
                <v-card flat>
                    <v-card-text>3</v-card-text>
                </v-card>
            </v-tab-item>
        </vuex-tabs-items>
    </v-container>
</template>

<script>
    import VuexTabsItems from "../components/_Helpers/VuexTabsItems";
    import Sidebar from "../components/_Helpers/Sidebar";
    import {mapActions} from "vuex";

    export default {
        name: "Welcome",
        components: {VuexTabsItems, Sidebar},

        data() {
            return {
                sidebarItems: [
                    {
                        header: 'Inne',
                        items: [
                            {
                                text: 'Umowy',
                                link: 'agreements',
                            },
                            {
                                text: 'Studenci',
                                link: 'students',
                            }

                        ]
                    },
                    {
                        header: 'Inne',
                        items: [
                            {
                                text: 'Inne',
                                link: 'other'
                            },
                            {
                                text: 'Ustawienia',
                                link: 'settings'
                            }
                        ]
                    }
                ],
            }
        },

        methods: {
            ...mapActions({
                setSidebarItems: 'sidebar/setItems'
            }),
        },

        created() {
            this.setSidebarItems(this.sidebarItems);
        },
    }
</script>

<style scoped>

</style>
