<template>
    <v-row no-gutters class="my-2" v-bind:class="loading ? 'opacity' : ''">
        <v-tooltip
            :right="!isDateVisible && !self"
            :left="!isDateVisible && self"
            :disabled="isDateVisible"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-col
                    cols="12" offset="0"
                    md="10" :offset-md="self ? 2 : 0"
                    lg="8" :offset-lg="self ? 4 : 0"
                    xl="5" :offset-xl="self ? 7 : 0"
                    v-bind="attrs"
                    v-on="on"
                >
                    <v-row no-gutters :class="messageGroupStart ? 'mt-5' : ''">
                        <v-col :order="self ? 2 : 1" cols="auto">
                            <v-avatar
                                :color="messageGroupStart ? (self ? 'primary' : 'grey lighten-2') : 'transparent'"
                                class="mx-3">
                                <template v-if="messageGroupStart">
                                    {{ userFirstName[0] + userLastName[0] }}
                                </template>
                            </v-avatar>
                        </v-col>
                        <v-col :order="self ? 1 : 2">
                            <v-card
                                elevation="0"
                                :color="self ? 'primary' : 'grey lighten-2'"
                                class="px-2 rounded-pill"
                            >
                                <v-card-text>{{ message }}</v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                    <v-scale-transition>
                        <v-row
                            no-gutters
                            v-if="isDateVisible"
                        >
                            <v-col
                                cols="12"
                                class="text-caption grey--text text--darken-1 mt-1 pt-0 px-7"
                                v-bind:class="self ? 'text-left' : 'text-right'"
                            >
                                {{ userFirstName + ' ' + userLastName + ' - ' + formatDate(date) }}
                            </v-col>
                        </v-row>
                    </v-scale-transition>
                </v-col>
            </template>
            <span>{{ formatDateFullDate(date) }}</span>
        </v-tooltip>
    </v-row>
</template>

<script>
import moment from 'moment';

export default {
    name: "ChatMessage",
    props: ['message', 'userFirstName', 'userLastName', 'userId', 'date', 'nextDate', 'self', 'messageGroupStart','messageGroup', 'messageGroupEnd', 'loading'],

    data() {
        return {
            isDateVisible: true,
        }
    },

    methods: {
        formatDate(date) {
            moment.locale('pl');
            return moment(date).fromNow();
        },

        formatDateFullDate(date) {
            moment.locale('pl');
            let formattedDate = date;

            if (moment(this.date).diff(moment(this.nextDate), 'year', true) > 1) {
                formattedDate = moment(date).format('DD.MM.YYYY HH:mm');
            }

            if (moment(this.date).diff(moment(this.nextDate), 'day', true) >= 1)
            {
                formattedDate = moment(date).format('DD.MM HH:mm');
            }

            if (moment(this.date).diff(moment(this.nextDate), 'day', true) < 1)
            {
                formattedDate = moment(date).format('HH:mm');
            }

            return formattedDate;
        },

        toggleDate() {
            if (!this.messageGroupEnd) {
                if (moment(this.date).diff(moment(this.nextDate), 'hours', true) > 1) {
                    this.isDateVisible = true;
                } else {
                    this.isDateVisible = !this.isDateVisible
                }
            }
        },
    },

    created() {
        this.isDateVisible = this.messageGroupEnd;

        if (moment(this.date).diff(moment(this.nextDate), 'hours', true) > 1) {
            this.isDateVisible = true;
        }
    }
}
</script>

<style scoped>
.opacity {
    opacity: 0.5;
}
</style>
