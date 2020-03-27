<template>
    <nav class="c-Navbar" v-bind:class="{ 'c-Navbar--right': isRightSidebar, 'c-Navbar--active': menuIsActive }">
        <ul class="c-Navbar__list">
            <li class="c-Navbar__hamburger" :class="{ 'c-Navbar__hamburger--active': menuIsActive }" v-on:click="menuIsActive = !menuIsActive"></li>
            <slot></slot>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: 'side-menu',
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
        data () {
            return {
                menuIsActive: this.isActive,
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
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-direction: column;
            list-style-type: none;
        }

        &__hamburger
        {
            &::before
            {
                display: flex;
                justify-content: center;
                align-items: center;
                width: 60px;
                height: 60px;
                font-family: "FontAwesome";
                content: '\f061';
                color: white;
                transition: all .75s ease-in-out;
            }

            &--active
            {
                &::before { transform: rotate(-180deg); }
            }
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