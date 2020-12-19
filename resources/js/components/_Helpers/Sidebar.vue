<template>
    <v-container class="sidebar">
<!--        <v-list nav dense class="pa-5" color="transparent">-->
<!--            <v-list-item-group>-->
<!--                <template v-for="item in items">-->
<!--                    <v-subheader v-if="item.header" v-text="item.header"></v-subheader>-->
<!--                    <v-list-item v-for="item in item.items" :to="item.link" link>-->
<!--                        <v-list-item-icon v-if="item.icon">-->
<!--                            <v-icon v-text="item.icon"></v-icon>-->
<!--                        </v-list-item-icon>-->
<!--                        <v-list-item-content>-->
<!--                            <v-list-item-title v-text="item.text"></v-list-item-title>-->
<!--                        </v-list-item-content>-->
<!--                    </v-list-item>-->
<!--                </template>-->
<!--            </v-list-item-group>-->
<!--        </v-list>-->
    </v-container>
</template>

<script>
    /*
* Component przyjmuje tablice z listą item'ów danego sidebar'a w następującej postaci:
* [
*   {
*      header: //Nazwa kategorii wyświetlana jako v-subheader
*      items: [
*          //Tablica elementów listy wyświetlana jako v-list-item
*          {
*              text: //Nazwa elementu
*              link: //Link do routing'u
*              icon: //Nazwa ikony mdi
*          }
*      ]
*   }
* ]
*/
    import {mapGetters} from "vuex";

    export default {
        name: "_Sidebar",

        computed: {
            ...mapGetters({
                items: 'sidebar/items'
            }),
        },
    }
</script>

<style lang="scss" scoped>
    .sidebar {
        height: 100%;
        max-width: 300px;
        padding: 0;
        background: #fff;
    }
</style>
