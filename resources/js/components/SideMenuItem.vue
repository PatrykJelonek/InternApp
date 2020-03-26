<template>
    <li class="c-Navbar__item">
        <a class="c-Navbar__link" :href="href">
            <side-menu-icon :iconName="icon" v-if="icon"></side-menu-icon>
            <slot></slot>
        </a>
    </li>
</template>

<script>
    import SideMenuIcon from './SideMenuIcon.vue';

    export default {
        name: 'Side Menu Item',
        props:
            {
                href: {
                    type: String,
                    required: true,
                },
                direction: {
                    type: String,
                    required: false,
                    default: 'left',
                    validator: (value) => ['left', 'right'].indexOf(value) > -1
                },
                icon:
                    {
                        type: String,
                        required: false,
                        validator: (value) => ['dashboard', 'profile'].indexOf(value) > -1
                    }
            },
        components: {
            SideMenuIcon
        },
    }
</script>

<style lang="scss" scoped>
    .c-Navbar
    {
        &__item
        {
            width: 100%;
            height: 40px;
        }

        &__link
        {
            position: relative;
            display: flex;
            justify-content: flex-start;
            padding-left: 5px;
            align-items: center;
            height: 100%;
            color: white;
            text-decoration: none;
            font-family: 'Montserrat', sans-serif;
            border-left: 5px solid rgba(0,0,0,.6);
            left: -5px;
            transition: left .1s ease-in-out;

            &:hover
            {
                left: 0px;
            }
        }

        &__icon
        {
            &::before
            {
                font-family: "FontAwesome";
                content:"\f013";
                font-size: 18px;
                font-weight: 100;
            }
        }
    }
</style>