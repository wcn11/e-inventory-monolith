<template>
    <div>
        Izin Akses
        <v-jstree :data="data" show-checkbox multiple allow-batch whole-row @item-click="itemClick"></v-jstree>
    </div>
</template>

<script>
import VJstree from 'vue-jstree'
export default {
    name: "Permission",
    props: ['access'],
    components: {
        VJstree
    },
    data(){
        return {
            data: [
                {
                  "text": "Dashboard",
                  "icon": "fas fa-tachometer-fastest"
                },
                {
                    "text": "Stock",
                    "icon": "fas fa-inventory",
                    "opened": "true",
                    "disabled": "true",
                    "children": [
                        {
                            "text": "Stock",
                            "icon": "fad fa-pallet-alt"
                        },
                        {
                            "text": "Stock Jalan",
                            "icon": "fad fa-truck-container"
                        },
                        {
                            "text": "Riwayat Stock",
                            "icon": "fad fa-clipboard-list-check",
                        },
                    ]
                },
                {
                    "text": "Data Barang",
                    "icon": "fad fa-boxes-alt",
                    "opened": "true",
                    "disabled": "true",
                    "children": [
                        {
                            "text": "Kategori Barang",
                            "icon": "fad fa-sort-size-down-alt",
                        },
                        {
                            "text": "Barang",
                            "icon": "fad fa-box-check",
                        },
                    ],
                },
                {
                    "text": "Pengguna & Otoritas",
                    "icon": "fad fa-user-cog",
                    "opened": "true",
                    "disabled": "true",
                    "children": [
                        {
                            "text": "Peran",
                            "icon": "fad fa-user-tag",
                        },
                        {
                            "text": "Pengguna",
                            "icon": "fad fa-users-medical",
                        },
                    ],
                },
                {
                    "text": "Manual",
                    "icon": "fad fa-sliders-v-square",
                    "opened": "true",
                    "disabled": "true",
                    "children": [
                        {
                            "text": "Produk Manual",
                            "icon": "fad fa-sitemap",
                        },
                        {
                            "text": "Stock Manual",
                            "icon": "fad fa-list-ol",
                        },
                    ],
                },
            ],
            permissions: [],

        }
    },
    methods: {
        itemClick (node, item) {
            this.checkItem(item.value)

            // BUG
            if (item.children.length !== 0){
                item.children.filter(value => {
                    return this.checkItem(value.value)
                })
            }
            this.$emit("setPermission", this.permissions)
        },
        checkItem(value){
            if(this.permissions.includes(value)){
                let index = this.permissions.indexOf(value)
                this.permissions.splice(index, 1)
            }else {
                this.permissions.push(value)
            }
        },
        setAccess(){
            if (this.access !== null){

                const access = JSON.parse(this.access)
                const data = this.data

                data.filter((value, indexData) => {

                    if (value.children.length > 0){
                        value.children.filter((childrenValue, indexChildren) => {

                            access.filter((accessValue) => {
                                if (accessValue.name === childrenValue.value){

                                    this.permissions.push(accessValue.name)
                                    this.data[indexData].children[indexChildren].selected = true

                                }
                            })
                        })

                    }else{

                        access.filter((accessValue) => {
                            if (accessValue.name === value.value){
                                this.permissions.push(accessValue.name)
                                this.data[indexData].selected = true
                            }
                        })

                    }

                })
            }
        }
    },
    mounted() {
        this.setAccess()
    }
}
</script>

<style scoped>
</style>
