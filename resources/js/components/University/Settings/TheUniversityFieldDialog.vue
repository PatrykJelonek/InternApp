<template>
    <v-dialog
        v-model="universityFieldDialog"
        class="component-background"
        persistent
        max-width="500"
    >
        <custom-card>

        </custom-card>
    </v-dialog>
</template>

<script>
import {mapGetters} from "vuex";
import CustomCard from "../../_General/CustomCard";

export default {
    name: "TheUniversityFieldDialog",
    components: {CustomCard},

    computed: {
        ...mapGetters({
            universityFieldDialog: 'helpers/universityFieldDialog'
        }),
    }
}
</script>

<style scoped>

</style>
