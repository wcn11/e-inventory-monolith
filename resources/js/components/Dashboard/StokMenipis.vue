<template>
    <!-- /.col -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-12" v-for="i in data">
            <div class="info-box shadow">
                <span class="info-box-icon bg-danger"><i class="fas fa-angle-double-down"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Shadows</span>
                    <span class="info-box-number">Small</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>
</template>

<script>
export default {
    name: "StokMenipis",
    props: {
        data: {
            type: Number,
        }
    }
}
</script>

<style scoped>

</style>
