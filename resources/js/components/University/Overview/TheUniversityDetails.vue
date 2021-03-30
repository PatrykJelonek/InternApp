<template>
    <v-card elevation="0" color="card-background">
        <v-list color="card-background">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="text-h5 font-weight-medium">Informacje podstawowe</v-list-item-title>
                    <v-list-item-subtitle>Ponieżej znajdują się podstawowe informacje na temat tego uniwersytetu.
                    </v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action>
                    <v-btn icon @click="show = !show">
                        <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
                    </v-btn>
                </v-list-item-action>
            </v-list-item>
        </v-list>
        <v-divider></v-divider>
        <v-expand-transition>
            <v-row v-show="show" no-gutters>
                <v-col cols="12" sm="12" md="6" lg="6">
                    <v-list nav color="card-background">
                        <v-list-item>
                            <v-list-item-content class="font-weight-bold">Nazwa:</v-list-item-content>
                            <v-list-item-content>{{ name }}</v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content class="font-weight-bold">Typ:</v-list-item-content>
                            <v-list-item-content>{{ type }}</v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content class="font-weight-bold">Adres:</v-list-item-content>
                            <v-list-item-content>{{ address }}</v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-col>
                <v-col cols="12" sm="12" md="6" lg="6">
                    <v-list nav color="card-background">
                        <v-list-item>
                            <v-list-item-content class="font-weight-bold">Adres email:</v-list-item-content>
                            <v-list-item-content>{{ email }}</v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content class="font-weight-bold">Numer kontaktowy:</v-list-item-content>
                            <v-list-item-content>{{ phone }}</v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content class="font-weight-bold">Strona internetowa:</v-list-item-content>
                            <v-list-item-content>{{ website }}</v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-col>
            </v-row>
        </v-expand-transition>
    </v-card>
</template>

<script>
export default {
    name: "TheUniversityDetails",
    props: ['name', 'type', 'address', 'email', 'phone', 'website'],

    data() {
        return {
            show: true,
        }
    }
}
</script>

<style scoped>

</style>
