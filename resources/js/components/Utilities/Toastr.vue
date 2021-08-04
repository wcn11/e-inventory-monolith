<template>

</template>

<script>
export default {
    name: "Toastr",
    props: ['message'],
    methods: {
        createToastr(){
            this.$toastr.s(this.message, "Berhasil");
        }
    },
    mounted() {
        this.createToastr()
    }
}
</script>

<style scoped>

</style>
