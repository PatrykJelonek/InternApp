<template>
    <v-row no-gutters>
        <template v-if="attachments.length > 0">
            <v-col
                cols="auto"
                class="mr-5 cursor-pointer"
                v-for="attachment in attachments"
                :key="attachment.id"
                @click="downloadAttachment({path: attachment.name})"
            >
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <div
                            v-bind="attrs"
                            v-on="on"
                        >
                            <div class="d-flex justify-center align-center">
                                <v-btn icon @click="download(attachment.name)">
                                    <v-icon x-large dense>mdi-file-document-outline</v-icon>
                                </v-btn>
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
        }),

        download(name) {
           this.downloadAttachment({name: name}).then(response => {
               let a = document.createElement('a');

               a.href = `data:application/pdf;base64,${response.data}`;
               a.download = name;
               a.click();
            }).catch((e) => {

            });

            return null;
        }
    }
}
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
</style>
