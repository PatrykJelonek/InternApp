<template>
    <v-container style="margin-top: 100px">
        <v-row class="my-15">
            <v-col cols="12" class="text-center">
                <h3 class="text-h3 font-weight-bold text-uppercase">Najnowsze Oferty Praktyk</h3>
            </v-col>
        </v-row>
        <v-row>
            <v-slide-group
                v-model="slider"
            >

            </v-slide-group>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: "TheLandingPageOffers",

    data() {
        return {
            slider: null,
        }
    }
}
</script>

<style scoped>

</style>
