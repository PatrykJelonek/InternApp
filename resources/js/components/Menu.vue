<template>
    <nav class="nav">
        <ul class="nav__list">
            <li class="nav__item" v-for="name in names">Menu Item by {{name}}</li>
        </ul>
    </nav>
</template>

<script>
    export default {
        data: function() {
            return {
                names: ["Patryk", "Wojtek", "Marcin"]
            }
        }
    }
</script>

<style lang="scss" scoped>
    .nav
    {
        width: 100vw;
        height: 60px;
        display: flex;
        justify-content: flex-end;

        &__list
        {
            list-style-type: none;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        &__item
        {
            margin-right: 10px;
        }
    }
</style>