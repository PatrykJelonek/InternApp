<template>
    <validation-observer ref="observer" v-slot="{ validate }">
        <v-form>
            <validation-provider
                v-slot="{ errors }"
                vid="password"
                rules="required"
            >
                <v-text-field
                    label="Nowe hasło"
                    v-model="password"
                    outlined
                    dense
                    hide-details="auto"
                    full-width
                    type="password"
                    placeholder="jankowalski@example.com"
                    :error-messages="errors"
                ></v-text-field>
            </validation-provider>
            <validation-provider
                v-slot="{ errors }"
                vid="passwordRepeat"
                rules="required"
            >
                <v-text-field
                    label="Powtórz nowe hasło"
                    v-model="passwordRepeat"
                    outlined
                    dense
                    hide-details="auto"
                    full-width
                    type="password"
                    :error-messages="errors"
                ></v-text-field>
            </validation-provider>
        </v-form>
    </validation-observer>
</template>

<script>
import {extend, setInteractionMode, ValidationProvider, ValidationObserver} from "vee-validate";

setInteractionMode('eager');

export default {
    name: "ResetPasswordForm",

    components: {
        ValidationProvider,
        ValidationObserver
    },

}
</script>

<style scoped>

</style>
