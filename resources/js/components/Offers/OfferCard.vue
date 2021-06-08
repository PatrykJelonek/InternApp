<template>
    <custom-card class="mb-5">
        <v-row>
            <v-col cols="auto" class="d-flex justify-center">
                <v-img
                    aspect-ratio="1/1"
                    src="https://bd90.pl/wp-content/uploads/2018/03/2000px-Intel-logo.svg.png"
                    alt="logo"
                    contain
                    height="60px"
                    width="60px"></v-img>
            </v-col>
            <v-col>
                <v-card-subtitle class="pb-0">{{ companyName }}</v-card-subtitle>
                <v-card-title class="pt-0">{{ title }}</v-card-title>
            </v-col>
        </v-row>

        <v-card-text>
            <v-row>
                <v-col cols="3"></v-col>
            </v-row>
        </v-card-text>
    </custom-card>
</template>

<script>
import CustomCard from "../_General/CustomCard";
export default {
    name: "OfferCard",
    components: {CustomCard},
    props: ['title', 'companyName']
}
</script>

<style scoped>

</style>
