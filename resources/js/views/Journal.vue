<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12">
                <h2 class="text-m">
                    <v-icon>mdi-text-box-multiple-outline</v-icon>
                    Wpisy
                </h2>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-card
                    color="cardBackground"
                    elevation="0"
                    class="pa-3 text-center"
                >
                    <v-icon>mdi-plus</v-icon>
                </v-card>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-card
                    color="cardBackground"
                    elevation="0"
                >
                    <v-list flat two-line color="transparent">
                        <v-list-item-group multiple>
                            <v-list-item :ripple="false">
                                <v-list-item-content>
                                    <v-list-item-title class="text-m font-weight-bold">Dzień 1</v-list-item-title>
                                    <v-list-item-subtitle class="text-m">20.01.2021</v-list-item-subtitle>
                                </v-list-item-content>
                                <v-list-item-action>
                                    <v-menu bottom left nudge-left="30px">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-icon
                                                v-bind="attrs"
                                                v-on="on"
                                            >mdi-dots-vertical</v-icon>
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
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    import PageDetailsHeader from "../components/Page/PageDetailsHeader";
    import JournalsList from "../components/Journals/JournalsList";
    import JournalFormModal from "../components/Journals/JournalFormModal";

    export default {
        name: "Journal",
        components: {JournalFormModal, JournalsList, PageDetailsHeader}
    }
</script>

<style lang="scss" scoped>

</style>
