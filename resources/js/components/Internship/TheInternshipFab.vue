<template>
    <v-speed-dial
        v-model="fab"
        bottom
        right
        direction="top"
        :transition="transition"
    >
        <template v-slot:activator>
            <v-btn
                v-model="fab"
                color="blue darken-2"
                dark
                fab
            >
                <v-icon v-if="fab">
                    mdi-close
                </v-icon>
                <v-icon v-else>
                    mdi-account-circle
                </v-icon>
            </v-btn>
        </template>
        <v-btn
            fab
            dark
            small
            color="green"
        >
            <v-icon>mdi-pencil</v-icon>
        </v-btn>
        <v-btn
            fab
            dark
            small
            color="indigo"
        >
            <v-icon>mdi-plus</v-icon>
        </v-btn>
        <v-btn
            fab
            dark
            small
            color="red"
        >
            <v-icon>mdi-delete</v-icon>
        </v-btn>
    </v-speed-dial>
</template>

<script>
export default {
    name: "TheInternshipFab",

    data() {
        return {
            direction: 'top',
            fab: false,
            fling: false,
            hover: false,
            tabs: null,
            top: false,
            right: true,
            bottom: true,
            left: false,
            transition: 'slide-y-reverse-transition',
        }
    }
}
</script>

<style scoped>

</style>
