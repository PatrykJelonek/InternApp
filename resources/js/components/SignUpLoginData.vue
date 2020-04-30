<template>
    <v-container>
        <v-row>
            <v-col cols="8">
                <h2>Dane Logowania</h2>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-text-field
                    v-model="email"
                    label="Email"
                    type="email"
                    prepend-inner-icon="mdi-at"
                    required
                    :outlined="outlinedInput"
                    :dense="denseInput"
                    hide-details="auto"
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-text-field
                    label="Hasło"
                    type="password"
                    prepend-inner-icon="mdi-lock"
                    required
                    :outlined="outlinedInput"
                    :dense="denseInput"
                    hide-details="auto"
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-text-field
                    label="Powtórz hasło"
                    type="password"
                    prepend-inner-icon="mdi-lock"
                    required
                    :outlined="outlinedInput"
                    :dense="denseInput"
                    hide-details="auto"
                ></v-text-field>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: "SignUpLoginData",
        data() {
            return {
                email: '',
                password: '',
                repeatPassword: '',

                outlinedInput: true,
                denseInput: false,
            }
        }
    }
</script>

<style scoped>

</style>
