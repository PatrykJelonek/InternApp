<template>
    <v-container fluid >
        <h2 class="text--welcome">Cześć, <br> {{user.first_name + " " + user.last_name}}</h2>
    </v-container>
</template>

<script>
    import VuexTabsItems from "../components/_Helpers/VuexTabsItems";
    import Sidebar from "../components/_Helpers/Sidebar";
    import {mapActions, mapGetters} from "vuex";

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

        computed: {
            ...mapGetters({
                user: 'auth/user',
            }),
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
    .text--welcome {
        font-size: 35px;
    }
</style>
