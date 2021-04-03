<template>
    <v-card
        max-width="300"
        class="pa-2 mr-10"
        elevation="5"
    >
        <v-row class="mb-4">
            <v-col>
                <v-card-title class="text-h6 font-weight-medium">Praktyki programistyczne</v-card-title>
                <v-card-subtitle>Polcom sp. z o.o.</v-card-subtitle>
            </v-col>
        </v-row>
        <v-row class="mb-4">
            <v-col>
                <v-sparkline
                    :value="[1,5,3,5,2,3,2,0,4]"
                    color="primary"
                    smooth="20"
                    height="150"
                    line-width="3"
                    stroke-linecap="round"
                ></v-sparkline>
            </v-col>
        </v-row>
        <v-row>
            <v-col >
                <v-btn color="primary" outlined block>Dziennik praktyk</v-btn>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
export default {
    name: "DashboardInternshipsCard",
    props: ['title', 'values', 'id']
}
</script>

<style scoped>

</style>
