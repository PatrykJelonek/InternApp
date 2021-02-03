<template>
    <v-dialog
        v-model="dialog"
        fullscreen
        transition="dialog-bottom-transition"
        content-class="mt-20"
    >
        <template v-slot:activator="{ on, attrs }">
            <v-row>
                <v-col cols="12">
                    <v-card
                        color="cardBackground"
                        elevation="0"
                        class="pa-3 text-center"
                        v-bind="attrs"
                        v-on="on"
                    >
                        <v-icon>mdi-plus</v-icon>
                    </v-card>
                </v-col>
            </v-row>
        </template>
        <v-card color="navBackground" class="rounded-t-lg">
            <v-container fluid>
                <v-row class="px-3">
                    <v-col cols="12">
                        <h2>Nowy wpis</h2>
                    </v-col>
                </v-row>
                <v-form>
                    <v-row class="px-3">
                        <v-col cols="12">
                            <v-menu
                                v-model="dateMenu"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                transition="scale-transition"
                                offset-y
                                min-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        v-model="journalEntryDate"
                                        label="Data wpisu"
                                        readonly
                                        outlined
                                        full-width
                                        hide-details
                                        v-bind="attrs"
                                        v-on="on"
                                        hint="DD.MM.YYYY format"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="journalEntryDate"
                                    @input="dateMenu = false"
                                    show-current
                                    locale="pl-pl"
                                ></v-date-picker>
                            </v-menu>
                        </v-col>
                    </v-row>
                    <v-row class="px-3">
                        <v-col cols="12">
                            <v-textarea
                                outlined
                                name="input-7-4"
                                label="Treść wpisu"
                                placeholder="Przykładowa treść wpisy do dziennika praktyk..."
                                rows="10"
                                full-width
                                hide-details
                            ></v-textarea>
                        </v-col>
                    </v-row>
                    <v-row class="px-3">
                        <v-col cols="12">
                            <v-btn
                                block
                                color="primary"
                                large
                            >
                                Dodaj wpis
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: "TheNewJournalEntryDialog",

    data() {
        return {
            dialog: false,
            journalEntryDate: null,
            journalEntryText: null,
            dateMenu: false,
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
