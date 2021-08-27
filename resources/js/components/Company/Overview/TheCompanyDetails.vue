<template>
    <custom-card>
        <custom-card-title>
            <template v-slot:default>Informacje podstawowe</template>
            <template v-slot:subheader>Poniżej znajdują się podstawowe informacje na temat tego uniwersytetu</template>
        </custom-card-title>
        <v-row no-gutters>
            <v-col cols="12" sm="12" md="6" lg="6">
                <v-list nav color="card-background">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title>Nazwa</v-list-item-title>
                            <v-list-item-subtitle>
                                {{ name }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title>Kategoria</v-list-item-title>
                            <v-list-item-subtitle>{{ category }}</v-list-item-subtitle>
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
    </custom-card>
</template>

<script>
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";

export default {
    name: "TheCompanyDetails",
    components: {CustomCardTitle, CustomCard},
    props: ['name', 'category', 'address', 'email', 'phone', 'website', 'description', 'draft', 'verified'],

}
</script>

<style scoped>

</style>
