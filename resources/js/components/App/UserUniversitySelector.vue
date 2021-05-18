<template>
    <v-select dense>

    </v-select>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "UserUniversitySelector",

    computed: {
        ...mapGetters({
            user: 'auth/user',
            navigationDrawer: 'helpers/navigationDrawer'
        }),
    },
}
</script>

<style scoped>

</style>
