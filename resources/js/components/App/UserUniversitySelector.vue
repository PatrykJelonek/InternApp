<template>
    <v-select
        v-model="localSelectedUniversity"
        :items="user.universities"
        item-text="name"
        item-value="slug"
        return-object
        dense
        @change="changeUniversity"
        outlined
        class="ml-5 text-caption font-weight-bold"
        style="max-width: 300px"
        hide-details
    ></v-select>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "UserUniversitySelector",

    data() {
        return {
            localSelectedUniversity: null,
        }
    },

    computed: {
        ...mapGetters({
            user: 'auth/user',
            selectedUniversity: 'helpers/selectedUniversity',
        }),
    },

    created() {
        if (this.selectedUniversity === undefined || this.selectedUniversity === null) {
            this.setSelectedUniversity(this.user.universities[0]);
            this.localSelectedUniversity = this.user.universities[0];
        } else {
            this.localSelectedUniversity = this.selectedUniversity;
        }
    },

    methods: {
        ...mapActions({
            setSelectedUniversity: 'helpers/setSelectedUniversity',
            fetchUniversity: 'university/fetchUniversity'
        }),

        changeUniversity() {
            if (this.selectedUniversity.slug !== this.localSelectedUniversity.slug) {
                this.setSelectedUniversity(this.localSelectedUniversity);
                this.$router.push({name: this.getRouteName(), params: {slug: this.localSelectedUniversity.slug}})
                this.fetchUniversity(this.localSelectedUniversity.slug);
            }
        },

        getRouteName() {
            if(this.$route.name.match(/university-*[a-z]*/g)) {
                return this.$route.name;
            } else {
                return 'university';
            }
        }
    }
}
</script>

<style scoped>

</style>
