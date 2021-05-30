<template>
    <validation-observer ref="observer" v-slot="{ validate }">
        <v-form class="pa-5">
            <v-row class="mb-1">
                <v-col cols="12" class="d-flex justify-center">
                    <v-avatar size="120" :color="avatarPreview || user.avatar_url ? '' : 'primary'" class="text-h5">
                        <v-img :src="avatarPreview !== null ? avatarPreview : '/'+user.avatar_url"
                               :alt="'Awatar użytkownika ' + user.first_name + ' ' + user.last_name">
                            <v-overlay absolute :value="loadPreview">
                                <v-progress-circular indeterminate size="64"></v-progress-circular>
                            </v-overlay>
                        </v-img>
                    </v-avatar>
                </v-col>
            </v-row>
            <v-row class="mb-1">
                <v-col cols="12">
                    <validation-provider
                        v-slot="{ errors, validate }"
                        vid="avatar"
                        rules="mimes:image/jpeg,image/png"
                    >
                        <v-file-input
                            v-model="avatar"
                            outlined
                            dense
                            hide-details="auto"
                            :error-messages="errors"
                            label="Awatar"
                            accept="image/jpeg,image/png"
                            @change="setAvatarPreview"
                            prepend-icon=""
                        ></v-file-input>
                    </validation-provider>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" class="d-flex justify-end">
                    <v-btn
                        color="primary"
                        outlined
                        :disabled="avatar === null"
                        @click="submit"
                    >Zapisz
                    </v-btn>
                </v-col>
            </v-row>
        </v-form>
    </validation-observer>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import {Base64} from 'js-base64';
import {mimes} from "vee-validate/dist/rules";
import {setInteractionMode, ValidationProvider, ValidationObserver, extend} from "vee-validate";

setInteractionMode('eager');

export default {
    name: "ChangeUserAvatarForm",

    components: {
        ValidationProvider,
        ValidationObserver
    },

    data() {
        return {
            avatarPreview: null,
            loadPreview: false,
            avatar: null,
            overlay: false,
            avatarBase64: {
                content: '',
                format: '',
            }
        }
    },

    computed: {
        ...mapGetters({
            user: 'auth/user',
        })
    },

    methods: {
        ...mapActions({
            updateUserAvatar: 'auth/updateUserAvatar',
            setSnackbar: 'snackbar/setSnackbar',
        }),

        setAvatarPreview() {
            this.loadPreview = true;
            if (this.avatar) {
                this.avatarPreview = URL.createObjectURL(this.avatar);
            } else {
                this.avatarPreview = ''
            }
            this.loadPreview = false;
        },

        async submit() {
            let formData = new FormData();
            formData.append('avatar', this.avatar);

            this.updateUserAvatar(formData).then((response) => {
                this.$store.commit('auth/CHANGE_USER_AVATAR', response.data);
                this.setSnackbar({message: 'Awatar został zmieniony!', color: 'success'});
            });
        }
    }
}

extend('mimes', {
    ...mimes,
    message: 'Plik musi być formatu jpeg lub png!',
});
</script>

<style lang="scss"></style>
