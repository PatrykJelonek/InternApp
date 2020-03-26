<template>
    <span class="c-Icon" :class="'c-Icon--'+iconName"></span>
</template>

<script>
    export default {
        name: 'Icon',
        props: {
            iconName: {
                type: String,
                required: true,
                validator: (value) => ['dashboard', 'profile', 'settings'].indexOf(value) > -1
            }
        }
    }
</script>

<style lang="scss" scoped>
    .c-Icon
    {
        position: relative;
        left: -5px;

        &::before
        {
            font-family: "FontAwesome";
            width: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            content:"";
            font-size: 18px;
        }

        &--dashboard
        {
            &::before { content:"\f201"; }
        }

        &--profile
        {
            &::before { content:"\f007"; }
        }

        &--settings
        {
            &::before { content:"\f013"; }
        }
    }
</style>