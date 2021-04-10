<template>
    <v-card elevation="0" color="card-background">
        <v-list color="card-background">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="text-h5 font-weight-medium">Aplikacje na praktyki</v-list-item-title>
                    <v-list-item-subtitle>Oto lista twoich aplikacji na praktyki.</v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action>
                    <v-btn-toggle borderless dense>
                        <v-tooltip top>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    small
                                    icon
                                    v-bind="attrs"
                                    v-on="on"
                                    @click="show = !show">
                                    <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                                </v-btn>
                            </template>
                            <span>{{ show ? 'Zwiń Listę' : 'Rozwiń Listę' }}</span>
                        </v-tooltip>
                    </v-btn-toggle>
                </v-list-item-action>
            </v-list-item>
        </v-list>
        <v-divider></v-divider>
        <v-expand-transition>
            <v-row v-show="show" no-gutters>
                <v-data-table
                    :headers="headers"
                    :items="availableOffers"
                    :items-per-page="5"
                    :loading="availableOffersLoading"
                    class="elevation-1"
                    @click:row="openDialog"
                >

                </v-data-table>
            </v-row>
        </v-expand-transition>
    </v-card>
</template>

<script>
export default {
name: "TheStudentOfferApplicationsList",

    data() {
        return {
            show: true,
            headers: [

            ]
        }
    },
}
</script>

<style scoped>

</style>
