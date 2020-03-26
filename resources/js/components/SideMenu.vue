<template>
    <nav class="c-Navbar" v-bind:class="{ 'c-Navbar--right': isRightSidebar, 'c-Navbar--active': isActive }" v-on:click="isActive = !isActive">
        <ul class="c-Navbar__list">
            <slot></slot>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: 'Side Menu',
        props: {
                direction: {
                    type: String,
                    required: false,
                    default: 'left',
                    validator: (value) => ['left', 'right'].indexOf(value) > -1
                },
                isActive: {
                    type: Boolean,
                    required: false,
                    default: false
                }
            },
        computed: {
            isRightSidebar() {
                return this.direction === 'right';
            }
        },
    }
</script>

<style lang="scss" scoped>
    .c-Navbar
    {
        height: 100vh;
        position: fixed;
        overflow: hidden;
        width: 60px;
        left: 0;  top: 0;
        background: #2F46AC;
        transition: width .3s ease-in-out;

        &__list
        {
            width: 100%;
            padding: 60px 0px;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-direction: column;
        }

        &--right
        {
            left: auto;
            right: 0;
        }

        &--active
        {
            width: 200px;
        }
    }
</style>