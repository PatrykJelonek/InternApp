<template>
    <v-row no-gutters>
        <template v-if="attachments.length > 0">
            <v-col
                cols="auto"
                class="mr-5 cursor-pointer"
                v-for="attachment in attachments"
                :key="attachment.id"
                @click="downloadAttachment({path: attachment.path})"
            >
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <div
                            v-bind="attrs"
                            v-on="on"
                        >
                            <div class="d-flex justify-center align-center">
                                <v-icon x-large dense>mdi-file-document-outline</v-icon>
                            </div>
                            <span class="d-flex justify-center align-center text-body-2">
                            {{ `${attachment.name.substr(0, 15)}...` }}
                        </span>
                        </div>
                    </template>
                    <span>{{ attachment.name }}</span>
                </v-tooltip>
            </v-col>
        </template>
        <template v-else>
            <v-col cols="12" class="text-center">
                Nie znaleziono żadnych załączników.
            </v-col>
        </template>
    </v-row>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: "Attachments",
    props: ['attachments', 'storage'],

    methods: {
        ...mapActions({
            downloadAttachment: 'helpers/downloadAttachment'
        })
    }
}
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
</style>
