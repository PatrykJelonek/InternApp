<template>
    <div>
        {{preview}}
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "TheInternshipPreview",

        computed: {
            ...mapGetters({
                preview: 'internship/preview'
            })
        },
    }
</script>

<style scoped>

</style>
