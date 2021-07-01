<template>
    <v-card elevation="0" color="card-background" :loading="userUniversitiesLoading">
        <template slot="progress">
            <v-progress-linear color="primary" indeterminate></v-progress-linear>
        </template>
        <v-list color="card-background">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="text-h5 font-weight-medium">Twoje uniwersytety</v-list-item-title>
                    <v-list-item-subtitle>Poniżej znajduje się lista uniwersytetów do których jesteś przypisany.
                    </v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action>
                    <v-btn-toggle dense borderless>
                        <v-btn
                            icon
                            @click="show = !show"
                            v-if="!userUniversitiesLoading && userUniversities.length > 0"
                        >
                            <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                        </v-btn>
                    </v-btn-toggle>
                </v-list-item-action>
            </v-list-item>
        </v-list>
        <v-divider></v-divider>
        <v-expand-transition>
            <div v-show="show">
                <v-row v-if="!userUniversitiesLoading && userUniversities.length > 0">
                    <v-col cols="12">
                        <v-list nav color="card-background">
                            <universities-list-item
                                v-for="university in userUniversities"
                                :key="university.id"
                                :id="university.id"
                                :name="university.name"
                                :address="university.street + ' ' + university.street_number"
                                :liked="university"
                                :slug="university.slug"
                            ></universities-list-item>
                        </v-list>
                    </v-col>
                </v-row>
                <v-divider v-if="userUniversities.length === 1 && !userUniversitiesLoading"></v-divider>
                <v-row v-if="userUniversities.length === 1 && !userUniversitiesLoading">
                    <v-col cols="12" class="text-center pt-8 pb-5">
                        <p class="text--secondary  mb-2">Zostaniesz przekierowany za <b>{{ secondsCounter }}</b> s do
                            <b>{{ userUniversities[0].name }}</b></p>
                        <v-btn
                            small
                            outlined
                            color="primary"
                            @click="stopRedirect"
                        >
                            {{ !stop ? 'Zatrzymaj przekierowanie' : 'Przejdź do uczelni' }}
                        </v-btn>
                    </v-col>
                </v-row>
            </div>
        </v-expand-transition>
        <v-row v-if="userUniversities.length < 1 && !userUniversitiesLoading">
            <v-col cols="12" class="text-center pt-8 pb-8">
                <p class="text--secondary">Nie jesteś przypisany do żadnego uniwersytetu.</p>
                <v-btn small outlined color="primary">Dołącz</v-btn>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
import PageTitle from "../_Helpers/PageTitle";
import {mapActions, mapGetters} from "vuex";
import UniversitiesListItem from "./UniversitiesListItem";

export default {
    name: "UniversitiesList",
    components: {UniversitiesListItem, PageTitle},

    data() {
        return {
            show: true,
            stop: false,
            secondsCounter: 5,
            interval: null,
            timeout: null,
        }
    },

    computed: {
        ...mapGetters({
            userUniversities: 'user/userUniversities',
            userUniversitiesLoading: 'user/userUniversitiesLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchUserUniversities: 'user/fetchUserUniversities',
        }),

        stopRedirect() {
            if (!this.stop) {
                clearInterval(this.interval);
                clearTimeout(this.timeout);
                this.stop = !this.stop;
            } else {
                this.$router.push({name: 'university', params: {slug: this.userUniversities[0].slug}});
            }
        },

        redirect() {
            this.interval = setInterval(() => {
                this.secondsCounter--;
            }, 1000);

            this.timeout = setTimeout(() => {
                clearInterval(this.interval);
                this.$router.push({name: 'university-overview', params: {slug: this.userUniversities[0].slug}});
            }, 5500)
        }
    },

    created() {
        if (this.userUniversities.length === 0) {
            this.fetchUserUniversities().then(() => {
                this.redirect();
            }).catch(() => {

            });
        }

        if (this.userUniversities.length === 1) {
            this.redirect();
        }

        this.$router.afterEach((to, from) => {
            clearTimeout(this.timeout);
        });
    }
}
</script>

<style scoped>

</style>
