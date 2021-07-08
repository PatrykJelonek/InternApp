<template>
    <v-dialog
        v-model="universitySpecializationDialog"
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
    name: "TheUniversitySpecializationDialog",
    components: {CustomCard},
    computed: {
        ...mapGetters({
            universitySpecializationDialog: 'helpers/universitySpecializationDialog'
        }),
    }
}
</script>

<style scoped>

</style>
