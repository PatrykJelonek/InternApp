<template>
    <v-list-item @click="$router.push({name: 'university-overview', params: {slug: slug}})">
        <v-list-item-icon class="ml-1 mr-3">
            <v-icon>{{ liked ? 'mdi-star' : 'mdi-star-outline' }}</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
            <v-list-item-title>{{ name }}</v-list-item-title>
            <v-list-item-subtitle>{{ address }}</v-list-item-subtitle>
        </v-list-item-content>
    </v-list-item>
</template>

<script>
export default {
    name: "UniversitiesListItem",
    props: ['id', 'name', 'address', 'liked', 'slug'],

    data() {
        return {

        }
    },

    methods: {
        like() {
            if (this.liked) {
                localStorage.removeItem('LIKED_UNIVERSITY_ID');
                this.liked = false;
            } else {
                localStorage.setItem('LIKED_UNIVERSITY_ID', this.id);
                this.liked = true;
            }
        },
    },

    created() {
        console.log(this.liked);
    }
}
</script>

<style scoped>

</style>
