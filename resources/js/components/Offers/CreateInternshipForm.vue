<template>
    <v-stepper v-model="stepper" class="card-background elevation-0">
        <v-stepper-header class="elevation-0">
            <v-stepper-step
                :complete="stepper > 1"
                step="1"
            >
                Miejsce Praktyk
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step
                :complete="stepper > 2"
                step="2"
            >
                Informacje Ogólne
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step step="3">
                Name of step 3
            </v-stepper-step>
        </v-stepper-header>
        <v-stepper-items class="elevation-0">
            <v-stepper-content step="1">
                <v-btn @click="stepper++">
                    next
                </v-btn>
            </v-stepper-content>
            <v-stepper-content  step="2">
                <v-btn @click="stepper++">
                    next
                </v-btn>
            </v-stepper-content>
            <v-stepper-content step="3">
                <v-btn @click="stepper--">
                    back
                </v-btn>
            </v-stepper-content>
        </v-stepper-items>
    </v-stepper>
</template>

<script>
export default {
    name: "CreateInternshipForm",
    data() {
        return {
            stepper: 1,
        }
    }
}
</script>

<style scoped>

</style>
