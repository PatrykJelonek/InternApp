<template>
    <validation-observer ref="observer" v-slot="{ validate }">
        <v-form>
            <v-row>
                <v-col cols="12">
                    <h3>Nowe zadanie</h3>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <validation-provider v-slot="{ errors }" vid="name" rules="required|max:64">
                        <v-text-field
                            v-model="task.name"
                            label="Nazwa zadania"
                            type="text"
                            full-width
                            outlined
                            hide-details="auto"
                            :error-messages="errors"
                        ></v-text-field>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <validation-provider v-slot="{ errors }" vid="description" rules="required|max:255">
                        <v-textarea
                            v-model="task.description"
                            outlined
                            name="input-7-4"
                            label="Treść zadania"
                            placeholder="Przykładowa treść zadania do dziennika praktyk..."
                            rows="10"
                            full-width
                            hide-details="auto"
                            :error-messages="errors"
                        ></v-textarea>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row v-has="['admin','university_worker','company_worker']">
                <v-col cols="12">
                    <validation-provider v-slot="{ errors }" vid="students_ids" rules="required">
                        <v-select
                            v-model="task.students_ids"
                            :items="internshipStudents"
                            :item-text="(item) => item.user.first_name + ' ' + item.user.last_name"
                            item-value="id"
                            label="Studenci"
                            multiple
                            chips
                            hint="Wybierz studentów dla których ma zostać dodany ten wpis..."
                            persistent-hint
                            :error-messages="errors"
                        ></v-select>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-btn
                        block
                        large
                        color="primary"
                        @click="submit"
                    >
                        Dodaj zadanie
                    </v-btn>
                </v-col>
            </v-row>
        </v-form>
    </validation-observer>
</template>

<script>
import {setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";
import {mapGetters} from "vuex";

setInteractionMode('eager');

export default {
    name: "InternshipCreateTaskForm",
    props: ['dialogName'],

    components: {
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            task: {
                name: '',
                description: '',
                internship_id: '',
                students_ids: [],
            },
            errorMessage: '',
            persistentHint: false,
        }
    },

    computed: {
        ...mapGetters({
            internshipStudents: 'internship/internshipStudents'
        })
    },

    methods: {
        submit() {
            this.$refs.observer.validate();
        }
    }
}
</script>

<style scoped>

</style>
