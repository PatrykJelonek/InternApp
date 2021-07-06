<template>
    <custom-card :loading="facultiesLoading && dataLoading">
        <custom-card-title>
            <template v-slot:default>Wydziały, kierunki i specjalności</template>
        </custom-card-title>

        <v-row no-gutters>
            <v-col cols="12">
                <v-treeview :items="data">
                    <template v-slot:append="{ item, open }">
                        <v-tooltip top>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    icon
                                    small
                                    v-bind="attrs"
                                    v-on="on"
                                    v-if="item.type !== 'specialization'">
                                    <v-icon>mdi-plus</v-icon>
                                </v-btn>
                            </template>
                            <span>Dodaj {{ item.type === 'faculty' ? 'Kierunek' : 'Specjalność' }}</span>
                        </v-tooltip>
                    </template>
                </v-treeview>
            </v-col>
        </v-row>
    </custom-card>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import moment from "moment";
import CustomCard from "../../_General/CustomCard";
import CustomCardTitle from "../../_General/CustomCardTitle";

export default {
    name: "TheUniversityFaculties",
    components: {CustomCardTitle, CustomCard},
    data() {
        return {
            show: true,
            data: [],
            dataLoading: true,
        }
    },

    computed: {
        ...mapGetters({
            university: 'university/university',
            faculties: 'university/faculties',
            facultiesLoading: 'university/facultiesLoading',
        }),
    },

    methods: {
        ...mapActions({
            fetchFaculties: 'university/fetchFaculties',
        }),

        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        }
    },

    created() {
        this.fetchFaculties(this.$route.params.slug).then(() => {
            this.dataLoading = true;
            this.faculties.forEach((faculty) => {
                let fields = [];
                faculty.fields.forEach((field) => {
                    let specializations = [];
                    field.specializations.forEach((specialization) => {
                        specializations.push({
                            id: specialization.id,
                            name: specialization.name,
                            type: 'specialization'
                        })
                    });
                    fields.push({
                        id: field.id,
                        name: field.name,
                        children: specializations,
                        type: 'field'
                    });
                });
                this.data.push({
                    id: faculty.id,
                    name: faculty.name,
                    type: 'faculty',
                    children: fields,
                });
            });
            this.dataLoading = false;
        }).catch((e) => {
            console.error(e);
        });
    }
}
</script>

<style scoped>

</style>
