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
        class="ml-5"
        style="max-width: 300px"
        hide-details
        v-if="user.companies.length > 0"
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
            selectedCompany: 'helpers/selectedCompany',
        }),
    },

    created() {
        if (this.selectedCompany === null || this.selectedCompany === undefined) {
            this.setSelectedCompany(this.user.companies[0]);
            this.localSelectedCompany = this.user.companies[0];
        } else {
            this.localSelectedCompany = this.selectedCompany;
        }
    },

    methods: {
        ...mapActions({
           setSelectedCompany: 'helpers/setSelectedCompany',
            fetchCompany: 'company/fetchCompany'
        }),

        changeCompany() {
            if (this.selectedCompany.slug !== this.localSelectedCompany.slug) {
                this.setSelectedCompany(this.localSelectedCompany);
                this.$router.push({name: this.getRouteName(), params: {slug: this.localSelectedCompany.slug}})
                this.fetchCompany(this.localSelectedCompany.slug);
            }
        },

        getRouteName() {
            if(this.$route.name.match(/company-*[a-z]*/g)) {
                return this.$route.name;
            } else {
                return 'company';
            }
        }
    }
}
</script>

<style scoped>

</style>
