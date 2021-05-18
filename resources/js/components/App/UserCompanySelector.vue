<template>
    <v-select
        v-model="localSelectedCompany"
        :items="user.companies"
        item-text="name"
        item-value="slug"
        return-object
        dense
        @change="changeCompany"
        outlined
    ></v-select>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "UserCompanySelector",

    data() {
        return {
            localSelectedCompany: null,
        }
    },

    computed: {
        ...mapGetters({
            user: 'auth/user',
            navigationDrawer: 'helpers/navigationDrawer',
            selectedCompany: 'helpers/selectedCompany'
        }),
    },

    methods: {
        ...mapActions({
           setSelectedCompany: 'helpers/setSelectedCompany'
        }),

        changeCompany() {
            this.setSelectedCompany(this.localSelectedCompany);
            this.$router.push({name: 'company', params: {slug: this.localSelectedCompany.slug}})
        }
    },

    created() {
        this.setSelectedCompany(this.selectedCompany ?? this.user.companies[0]);
        this.localSelectedCompany = this.selectedCompany ?? this.user.companies[0];
    }
}
</script>

<style scoped>

</style>
