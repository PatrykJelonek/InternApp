<template>
    <expand-card
        title="Informacje podstawowe"
        description="Ponieżej znajdują się podstawowe informacje na temat tego uniwersytetu."
    >
        <v-row no-gutters>
            <v-col cols="12" sm="12" md="6" lg="6">
                <v-list nav color="card-background">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title>Nazwa</v-list-item-title>
                            <v-list-item-subtitle>{{ name }}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title>Typ</v-list-item-title>
                            <v-list-item-subtitle>{{ type }}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title>Adres</v-list-item-title>
                            <v-list-item-subtitle>{{ address }}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-col>
            <v-col cols="12" sm="12" md="6" lg="6">
                <v-list nav color="card-background">
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title>Adres email</v-list-item-title>
                            <v-list-item-subtitle>{{ email }}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title>Numer kontaktowy</v-list-item-title>
                            <v-list-item-subtitle>{{ phone }}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title>Strona internetowa</v-list-item-title>
                            <v-list-item-subtitle>{{ website }}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-col>
        </v-row>
    </expand-card>
</template>

<script>
import ExpandCard from "../../_Helpers/ExpandCard";

export default {
    name: "TheUniversityDetails",
    components: {ExpandCard},
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
