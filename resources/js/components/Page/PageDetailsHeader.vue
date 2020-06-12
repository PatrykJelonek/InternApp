<template>
    <v-container fluid class="white pa-0 ma-0 detail_header d-flex align-center">
        <v-container>
            <v-row>
                <v-col cols="12" class="pa-1">
                    <h2 class="display-1 font-weight-black grey--text text--darken-4">{{ header }}</h2>
                    <v-subheader v-if="subheader" class="pa-1">{{ subheader }}</v-subheader>
                </v-col>
            </v-row>
        </v-container>
    </v-container>
</template>

<script>
    export default {
        name: "PageDetailsHeader",

        props: {
            header: {
                type: String,
                required: true
            },
            subheader: {
                type: String,
                required: false
            },
        }
    }
</script>

<style scoped>
    .detail_header {
        height: 200px;
    }
</style>
