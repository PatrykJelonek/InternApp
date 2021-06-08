<template>
    <v-container fluid>
        <v-row v-if="!userLoading">
            <v-col cols="12">
                <page-title></page-title>
            </v-col>
            <v-col
                cols="12"
                sm="10" offset-sm="1"
                md="8" offset-md="2"
                lg="6" :offset-lg="user.universities.length > 0 || user.companies.length > 0 ? '0' : '3'"
                xl="6" :offset-xl="user.universities.length > 0 || user.companies.length > 0 ? '0' : '3'"
                class="text-center"
            >
                <v-card elevation="0" class="overflow-hidden">
                    <v-img src="../../img/pattern.png" height="200px" class="primary overflow-visible pa-0"
                           content-class="d-flex justify-center">
                        <v-card-title class="pa-0">
                            <v-avatar size="200px" class="d-flex justify-center"
                                      style="top: 100px; border: 8px solid white;">
                                <v-img
                                    :src="'/'+user.avatar_url"
                                       :alt="user.first_name + ' ' + user.last_name + ' avatar'"
                                ></v-img>
                            </v-avatar>
                        </v-card-title>
                    </v-img>
                    <v-card-text style="margin-top: 100px">
                        <v-list>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title class="text-overline">Imię i Nazwisko</v-list-item-title>
                                    <v-list-item-subtitle>{{
                                            user.first_name + ' ' + user.last_name
                                        }}
                                    </v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title class="text-overline">Email</v-list-item-title>
                                    <v-list-item-subtitle>{{ user.email }}</v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title class="text-overline">Nr Kontaktowy</v-list-item-title>
                                    <v-list-item-subtitle>{{ user.phone }}</v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item-action class="mx-0" v-if="user.id !== currentUser.id">
                                <v-btn outlined color="primary" @click="createChat(user.id)">Napisz Wiadomość</v-btn>
                            </v-list-item-action>
                        </v-list>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col
                cols="12"
                sm="10" offset-sm="1"
                md="8" offset-md="2"
                lg="6" offset-lg="0"
                xl="6" offset-xl="0"
            >
                <v-row>
                    <v-col
                        cols="12"
                        v-if="user.universities.length > 0"
                    >
                        <expand-card
                            title="Uczelnie"
                            :description="`Lista uczelni do których przynależy ${fullName}.`"
                            :expand="false"
                            :actions="false"
                        >
                            <v-list>
                                <v-list-item v-for="university in user.universities" :key="university.id"
                                             class="cursor-pointer">
                                    <v-list-item-content
                                        @click="$router.push({name: 'university', params: {slug: university.slug}})">
                                        <v-list-item-title class="text-overline">Nazwa</v-list-item-title>
                                        <v-list-item-subtitle>{{ university.name }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </expand-card>
                    </v-col>
                    <v-col
                        cols="12"
                        v-if="user.companies.length > 0"
                    >
                        <expand-card
                            title="Firmy"
                            :description="`Lista firm do których przynależy ${fullName}.`"
                            :expand="false"
                            :actions="false"
                        >
                            <v-list>
                                <v-list-item v-for="company in user.companies" :key="company.id" class="cursor-pointer">
                                    <v-list-item-content
                                        @click="$router.push({name: 'university', params: {slug: company.slug}})">
                                        <v-list-item-title class="text-overline">Nazwa</v-list-item-title>
                                        <v-list-item-subtitle>{{ company.name }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </expand-card>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
        <v-row v-else class="text-center">
            <v-col cols="12">
                <page-loader></page-loader>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import PageTitle from "../components/_Helpers/PageTitle";
import {mapActions, mapGetters} from "vuex";
import PageLoader from "../components/_General/PageLoader";
import ExpandCard from "../components/_Helpers/ExpandCard";

export default {
    name: "Profile",
    components: {ExpandCard, PageLoader, PageTitle},

    data() {
        return {
            fullName: '',
        }
    },

    methods: {
        ...mapActions({
            fetchUser: 'user/fetchUser',
            createOneOnOneChat: 'user/createOneOnOneChat',
            setBreadcrumbs: 'helpers/setBreadcrumbs'
        }),

        async createChat(userId) {
            await this.createOneOnOneChat(userId).then((response) => {
                this.$router.push({name: 'chat', params: {uuid: response.data.uuid}})
            }).catch((e) => {

            })
        },
    },

    computed: {
        ...mapGetters({
            currentUser: 'auth/user',
            user: 'user/user',
            userLoading: 'user/userLoading'
        }),
    },

    created() {
        this.fetchUser(this.$route.params.id).then(() => {
            this.fullName = this.user.first_name + ' ' + this.user.last_name;

            this.setBreadcrumbs([
                {text: 'Panel', to: {name: 'panel'}, exact: true},
                {text: this.user.first_name + ' ' + this.user.last_name, to: {name: 'user', params: {slug: this.$route.params.id}}, exact: true},
            ]);
        }).catch((e) => {

        })
    }
}
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
</style>
